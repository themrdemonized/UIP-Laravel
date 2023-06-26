<?php

namespace App\Traits;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Mail;

trait SendMessage
{
      public function sendMessage($subject, $body, $objectId = null, $extraUsers = [])
    {
        $users = [];

        if($objectId === null){
            $users = User::managers()->get();
        } else {
            $users = User::managers()->whereHas('objects', function (Builder $query) use ($objectId){
                $query->where('id', $objectId);
            })->get();
        }

        // $extraUsers = [];
        // $extraUsers[] = "413314@uip-dv.ru";
        // $extraUsers[] = "kas@uip-dv.ru";
        // $extraUsers[] = "demonized@ttt";

        Mail::send([], [], function ($message) use ($subject, $body, $users, $extraUsers) {
            foreach ($users as $user){
                $message->to($user->email);
                $message->subject("$subject");
                $message->setBody("$body", 'text/html');
            }
            foreach ($extraUsers as $user){
                $message->to($user);
                $message->subject("$subject");
                $message->setBody("$body", 'text/html');
            }
        });
    }

}
