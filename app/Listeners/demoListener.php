<?php

namespace App\Listeners;

use App\Events\demoEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class demoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\demoEvent  $event
     * @return void
     */
    public function handle(demoEvent $event)
    {
        $user = User::find($event->user_id);
        $data=['name'=>$user->name, 'bodyData'=>'Thanks for using our application'];
        Mail::send('mail',$data, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Event Testing');
        });
    }
}
