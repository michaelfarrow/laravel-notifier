<?php namespace Weyforth\Notifier;

use User;
use Mail;
use Config;

class EmailNotifier implements NotifierInterface
{

    public function notify(NotfierUserInterface $user, $subject, $view, $data = array())
    {
        Mail::send(
            $view,
            array_merge($data, compact('user')),
            function ($message) use ($user, $subject) {
                $message->from(
                    Config::get('notifier.address'),
                    Config::get('notifier.name')
                );
                $message->subject($subject);
                $message->to($user->emailAddress());
            }
        );
    }

    public function subscribe($email, $list)
    {
        
    }

}