<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Event;

use App\Models\JoinRequest;
use App\Models\Report;
use App\Models\User;

class EventController extends Controller
{

  /**
   * Shows all events.
   *
   * @return Response
   */
  static function getPublicEvents()
  {
    return Event::where('public', '=', true)->where('eventcanceled', '=', false)->get();
  }

  public static function searchPublicEvents(Request $request)
  {
    $search = $request->input('search');
    $events = Event::whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$search])
      ->where('public', '=', true)->get();
    return $events;
  }

  public function show($id)
  {
    $event = Event::find($id);

    if (is_null($event))
      return abort(404, 'Event not found');

    $user = User::find(Auth::id());
    $polls = $event->polls()->get();
    $comments = $event->comments()->orderBy('commentdate', 'desc')->paginate(3);
    if ($event->public && !Auth::check()) {
      return view('pages.event', [
        'event' => $event
      ]);
    } else if (Auth::check() && ($user->isAttendee($event) || $event->public || $user->userid == $event->userid))
      return view('pages.event', [
        'event' => $event, 'user' => $user, 'comments' => $comments,
      ]);
    else
      return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
  }

  /**
   * Display the Administration Panel
   *
   * @return View
   */
  public function show_dashboard(int $eventid)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return abort(404, 'User not found');

    $event = Event::find($eventid);
    if (is_null($event))
      return abort(404, 'Event not found');

    $this->authorize('dashboard', $event);

    $attendees = DB::table('attendee')
      ->select('attendeeid', 'eventid')
      ->where('eventid', $eventid)
      ->get()
      ->map(function ($attendee) {

        $user = User::find($attendee->attendeeid);
        $event = Event::find($attendee->eventid);

        return [
          'user' => $user,
          'event' => $event,
        ];
      });

    $join_requests = JoinRequest::orderByDesc('joinrequestid')->get()
      ->where('eventid', '=', $eventid)
      ->map(function ($request) {

        $requester = User::find($request->requesterid);

        return [
          'request' => $request,
          'requester' => $requester,
        ];
      });

    return view('pages.event.dashboard', [
      'organizer' => $organizer,
      'event' => $event,
      'attendees' => $attendees,
      'requests' => $join_requests,
    ]);
  }


  public function denyJoinRequest(int $eventid, int $id)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'User not found, id: ' . Auth::id(),
        'errors' => ['user' => 'User not found, id: ' . Auth::id()]
      ], 404);
    $event = Event::find($eventid);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Event not found, id: ' . $eventid,
        'errors' => ['event' => 'Event not found, id: ' . $eventid]
      ], 404);
    $request = JoinRequest::find($id);
    if (is_null($request))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Request not found, id: ' . $id,
        'errors' => ['request' => 'Request not found, id: ' . $id]
      ], 404);


    if ($event->userid !== $organizer->userid || $request->eventid !== $event->eventid)
      return response()->json([
        'status' => 'Forbidden',
        'msg' => 'Resource cannot be accessed',
        'errors' => ['request' => 'Request cannot be accessed']
      ], 403);

    if ($request->requestStatus)
      return response()->json([
        'status' => 'OK',
        'msg' => 'Request was already denied',
      ], 200);

    $request->requeststatus = false;
    $request->save();

    return response()->json([
      'status' => 'OK',
      'msg' => 'Request was successfully denied',
    ], 200);
  }



  public function acceptJoinRequest(int $eventid, int $id)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'User not found, id: ' . Auth::id(),
        'errors' => ['user' => 'User not found, id: ' . Auth::id()]
      ], 404);
    $event = Event::find($eventid);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Event not found, id: ' . $eventid,
        'errors' => ['event' => 'Event not found, id: ' . $eventid]
      ], 404);
    $request = JoinRequest::find($id);
    if (is_null($request))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Request not found, id: ' . $id,
        'errors' => ['request' => 'Request not found, id: ' . $id]
      ], 404);

    if ($event->userid !== $organizer->userid || $request->eventid !== $event->eventid)
      return response()->json([
        'status' => 'Forbidden',
        'msg' => 'Resource cannot be accessed',
        'errors' => ['request' => 'Request cannot be accessed']
      ], 403);

    if ($request->requeststatus)
      return response()->json([
        'status' => 'OK',
        'msg' => 'Request was already accepted',
      ], 200);

    $request->requeststatus = true;
    $request->save();

    return response()->json([
      'status' => 'OK',
      'msg' => 'Request was successfully accepted',
    ], 200);
  }

  public function manageEvent($id)
  {
    $event = Event::find($id);
    if (is_null($event))
      return abort(404, 'Event not found');

    $this->authorize('manage', $event);
    return view('pages.event.manage', ['event' => $event]);
  }

  public function setEventVisibilityPublic($id)
  {
    $event = Event::find($id);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'User not found, id: ' . $id,
        'errors' => ['user' => 'User not found, id: ' . $id]
      ], 404);

    $this->authorize('manage', $event);

    $event->public = TRUE;
    $event->save();

    return response()->json([
      'status' => 'OK',
      'msg' => 'Successfully set event visibility to public',
    ], 200);
  }

  public function setEventVisibilityPrivate($id)
  {
    $event = Event::find($id);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'User not found, id: ' . $id,
        'errors' => ['user' => 'User not found, id: ' . $id]
      ], 404);

    $this->authorize('manage', $event);

    $event->public = FALSE;
    $event->save();

    return response()->json([
      'status' => 'OK',
      'msg' => 'Successfully set event visibility to private',
    ], 200);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int $id Id of the user
   * @return \Illuminate\Http\RedirectResponse
   */
  public function cancelEvent(int $id)
  {
    $event = Event::find($id);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Event not found, id: ' . $id,
        'errors' => ['event' => 'Event not found, id: ' . $id]
      ], 404);

    $this->authorize('manage', $event);

    if ($event->eventcanceled)
      return response()->json([
        'status' => 'OK',
        'msg' => 'Event was already canceled',
      ], 200);

    $event->eventcanceled = true;
    $event->save();

    return response()->json([
      'status' => 'OK',
      'msg' => 'Event was successfully canceled',
    ], 200);
  }

  public function userEvents()
  {
    $this->authorize('list', Event::class);
    $myEvents = Auth::user()->events()->get();

    return view('pages.myEvents', ['events' => $myEvents]);
  }

  public function organizerEvents()
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return abort(404, 'User not found');
    $this->authorize('organizerEvents', $organizer);
    $events = Event::where('userid', $organizer->userid)->get();

    return response()->json(
      view('partials.content.organizerEvents', ['events' => $events])->render(),
      200
    );
  }

  public function myEvents(Request $request)
  {
    $user = Auth::user();
    if (is_null($user))
      return abort(404, 'User not found');
    $this->authorize('list', Event::class);

    $currentDate = Carbon::now();

    if ($request->hasPassed == 1) {
      $events = Auth::user()->events()->where('enddate', '<=', $currentDate)->get();
    } else {
      $events = Auth::user()->events()->where('enddate', '>', $currentDate)->get();
    }

    return response()->json(
      view('partials.content.eventCards', ['events' => $events])->render(),
      200
    );
  }

  public function attendees(Request $request, $id)
  {
    $user = User::find(Auth::id());
    if (is_null($user))
      return abort(404, 'User not found');
    $event = Event::find($id);
    if (is_null($event))
      return abort(404, 'Event not found');

    $attendees = DB::table('attendee')
      ->select('attendeeid', 'eventid')
      ->where('eventid', $id)
      ->get()
      ->map(function ($attendee) {

        $user = User::find($attendee->attendeeid);
        $event = Event::find($attendee->eventid);

        return [
          'user' => $user,
          'event' => $event,
        ];
      });

    if ($user->isAttendee($event) || $event->public || $user->userid == $event->userid)
      return view('pages.attendees', ['attendees' => $attendees]);
    else
      return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
  }

  public function view_add_user($id)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return abort(404, 'User not found');
    $event = Event::find($id);
    if (is_null($event))
      return abort(404, 'Event not found');
    $this->authorize('view_add_user', $event);

    $usersInvited = Auth::user()->invites_sent()->get();
    $usersAttending = Event::find($id)->events()->get();

    $users = User::get();

    $usersAttending->push(Auth::user());

    $users = $users->diff($usersInvited);
    $users = $users->diff($usersAttending);

    return view('pages.add_users', ['users' => $users]);
  }

  public function addUser(Request $request, int $userid, int $eventid)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return abort(404, 'User not found');

    $user = User::find($userid);
    if (is_null($user))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'User not found, id: ' . $userid,
        'errors' => ['user' => 'User not found, id: ' . $userid]
      ], 404);

    $event = User::find($eventid);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Event not found, id: ' . $eventid,
        'errors' => ['event' => 'Event not found, id: ' . $eventid]
      ], 404);

    $this->authorize('addUser', $organizer);

    $event->events()->attach($userid);

    return response()->json([
      'status' => 'OK',
      'msg' => 'Successfully added user ' . $user->name . 'to event' . $event->eventname,
    ], 200);
  }

  public function removeUser(Request $request, int $userid, int $eventid)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return abort(404, 'User not found');
    $user = User::find($userid);
    if (is_null($user))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'User not found, id: ' . $userid,
        'errors' => ['user' => 'User not found, id: ' . $userid]
      ], 404);

    $event = User::find($eventid);
    if (is_null($event))
      return response()->json([
        'status' => 'Not Found',
        'msg' => 'Event not found, id: ' . $eventid,
        'errors' => ['event' => 'Event not found, id: ' . $eventid]
      ], 404);

    $this->authorize('removeUser', $organizer);

    $event->events()->detach($userid);

    return response()->json([
      'status' => 'OK',
      'msg' => 'Successfully removed user ' . $user->name . 'from event' . $event->eventname,
    ], 200);
  }

  public function delete(Request $request, $id)
  {
    $event = Event::find($id);

    $this->authorize('delete', $event);
    $event->delete();

    return $event;
  }

  public function edit($id)
  {
    $event = Event::find($id);

    if (is_null($event))
      return abort(404, 'Event not found');

    $user = User::find(Auth::id());

    $this->authorize('edit', $event);

    return view('pages.event.edit', [
      'event' => $event, 'user' => $user
    ]);
  }

  public function update(Request $request, int $id)
  {
    $event = Event::find($id);
    if (is_null($event))
      return redirect()->back()->withErrors(['event' => 'Event not found, id: ' . $id]);

    $this->authorize('update', $event);

    $validator = Validator::make($request->all(), [
      'eventname' => 'required|string|max:255',
      'description' => 'required|string|max:500',
      'eventphoto' => 'image|mimes:jpg,png,jpeg,gif,svg|max:4096',
      'eventaddress' => 'required|string|max:255',
      'startdate' => 'required|date',
      'enddate' => 'required|date|after:startdate',
    ]);

    if ($validator->fails()) {
      $errors = [];
      foreach ($validator->errors()->messages() as $key => $value) {
        $errors[$key] = is_array($value) ? implode(',', $value) : $value;
      }

      return redirect()->back()->withInput()->withErrors($errors);
    }

    $repeatedName = Event::where('eventname', $request->eventname)->first();

    if (isset($request->eventname) && $repeatedName == null) {
      $event->eventname = $request->eventname;
    } else {
      return redirect()->back()->withInput()->withErrors(['event_repeated' => 'Event name already exists']);
    }

    if (isset($request->description)) $event->description = $request->description;
    if (isset($request->eventaddress)) $event->eventaddress = $request->eventaddress;
    if (isset($request->startdate)) $event->startdate = $request->startdate;
    if (isset($request->enddate)) $event->enddate = $request->enddate;

    if ($request->file('image') != null) {
      $name = $request->file('image')->getClientOriginalName();
      $upload = new Upload();
      $upload->filename = $name;
      $upload->save();
      $request->image->storeAs('public/images/', "image-$upload->uploadid.png");
      $event->eventphoto = $upload->uploadid;
    }
    $event->save();

    return redirect()->route('show_event', [$event->eventid]);
  }

  public function showForms()
  {
    $tags = TagController::getAllTags();
    $categories = CategoryController::getAllCategories();

    return view('pages.createEvent', ['categories' => $categories, 'tags' => $tags]);
  }

  public function createEvent(Request $request)
  {
    $organizer = User::find(Auth::id());
    if (is_null($organizer))
      return abort(404, 'User not found');

    $this->authorize('createEvent', $organizer);

    $validator = Validator::make(
      $request->all(),
      [
        'name' => 'required|string|min:3|max:255',
        'eventaddress' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:3|max:500',
        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
        'endDate' => 'required|date',
        'startDate' => 'required|date',
      ]
    );

    $errors = [];
    if ($validator->fails()) {

      foreach ($validator->errors()->messages() as $key => $value) {
        $errors[$key] = is_array($value) ? implode(',', $value) : $value;
      }

      return redirect()->back()->withInput()->withErrors($errors);
    }

    $event = new Event;

    $repeatedName = Event::where('eventname', $request->name)->first();

    if (isset($request->name) && $repeatedName == null) {
      $event->eventname = $request->name;
    } else {
      return redirect()->back()->withInput()->withErrors(['event_repeated' => 'Event name already exists']);
    }

    $event->eventaddress = $request->eventaddress;
    $event->description = $request->description;
    $event->startdate = $request->startDate;
    $event->enddate = $request->endDate;

    if ($request->has('private')) {
      $event->public = false;
    } else {
      $event->public = true;
    }

    $name = $request->file('image')->getClientOriginalName();
    $upload = new Upload();
    $upload->filename = $name;
    $upload->save();
    $request->image->storeAs('public/images/', "image-$upload->uploadid.png");


    $event->eventphoto = $upload->uploadid;

    $event->userid = Auth::id();


    $tags = TagController::getAllTags();
    $categories = CategoryController::getAllCategories();
    $event->save();
    foreach ($categories as $category) {
      if ($request->has("category-$category->categoryid")) {
        $event->eventCategories()->attach($category->categoryid);
      }
    }

    foreach ($tags as $tag) {
      if ($request->has("tag-$tag->tagid")) {
        $event->eventTags()->attach($tag->tagid);
      }
    }

    return redirect("/event/$event->eventid");
  }

  public function reportEvent(Request $request, int $eventid)
  {
    $user = User::find(Auth::id());
    if (is_null($user))
      return abort(404, 'User not found');

    $event = Event::find($eventid);
    if (is_null($event))
      return abort(404, 'Event not found');

    $this->authorize('reportEvent', $user);

    $validator = Validator::make(
      $request->all(),
      [
        'message' => 'required|string|min:3|max:100',
      ]
    );

    $errors = [];
    if ($validator->fails()) {

      foreach ($validator->errors()->messages() as $key => $value) {
        $errors[$key] = is_array($value) ? implode(',', $value) : $value;
      }

      return redirect()->back()->withInput()->withErrors($errors);
    }

    $report = new Report();

    $report->reporterid = Auth::id();
    $report->eventid = $eventid;
    $report->message = $request->input('message');

    $report->save();

    return redirect()->route('show_event', $eventid)->with('success', 'Your report has been submited.');
  }
}
