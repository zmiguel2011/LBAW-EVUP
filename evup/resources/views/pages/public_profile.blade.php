@extends('layouts.app')

@section('title', "- Public Profile")

@section('content')
<article class="rounded-t-3xl">
        <div class="px-6 ">
            <div class="text-center mt-2">
                <div class="mr-2">
                    <img alt="user_photo" class="mx-auto w-12 h-12 rounded-full" src="{{ asset('storage/images/image-'.$user->userphoto.'.png')}}">
                </div>
                <h3 class="text-2xl text-slate-700 font-bold leading-normal mb-1">
                    {{ $user->name }}
                    @if(Auth::user()->usertype == 'Admin' || Auth::id() == $user->userid)
                        <button>
                            <a aria-hidden="true" href="{{ route('edit_user', ['id' => $user->userid]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        </button>
                    @endif
                </h3>
                <div class="text-xs mt-0 mb-2 text-slate-400 font-bold uppercase">
                    <i class="text-slate-400 opacity-75"></i>{{ $user->username }} / {{ $user['email'] }}
                </div>
            </div>
    </div>
    <div>
        <section id="myEventsHeader" class="m-4 text-center">
            <h2 class="text-2xl font-semibold leading-tight">My Events</h2>
        </section>
        <div id="Events" class="flex flex-wrap justify-center gap-2">
            @each('partials.eventCard', $events, 'event')
        </div>
    </div>
</article>

@endsection
