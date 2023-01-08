<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether is signed in.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function list()
    {
        return Auth::check();
    }

    public function manage(User $organizer, Event $event)
    {
        return $organizer->usertype == 'Organizer' && Auth::id() == $event->userid;
    }
    
    public function dashboard(User $organizer, Event $event)
    {
        return $organizer->usertype == 'Organizer' && Auth::id() == $event->userid;
    }

    public function edit(User $organizer, Event $event)
    {
        return $organizer->usertype == 'Organizer' && Auth::id() == $event->userid;
    }

    public function update(User $organizer, Event $event)
    {
        return $organizer->usertype == 'Organizer' && Auth::id() == $event->userid;
    }

    public function view_add_user(User $organizer, Event $event)
    {
        return $organizer->usertype == 'Organizer' && Auth::id() == $event->userid;
    }

    public function createComment(User $user, Event $event)
    {
        return $user->isAttendee($event) || ($user->usertype == 'Organizer' && $user->userid == $event->userid);
    }

}