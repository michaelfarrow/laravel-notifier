<?php
/**
 * Email notifier.
 *
 * @author    Mike Farrow <contact@mikefarrow.co.uk>
 * @license   Proprietary/Closed Source
 * @copyright Mike Farrow
 */

namespace Weyforth\Notifier;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class EmailNotifier implements NotifierInterface
{


    /**
     * {@inheritdoc}
     */
    public function notify(
        NotfierUserInterface $user,
        $subject,
        $view,
        array $data = array()
    ) {
        Mail::send(
            $view,
            array_merge($data, compact('user')),
            function ($message) use ($user, $subject) {
                $message->from(
                    Config::get('notifier::address'),
                    Config::get('notifier::name')
                );
                $message->subject($subject);
                $message->to($user->emailAddress());
            }
        );
    }


    /**
     * {@inheritdoc}
     */
    public function subscribe($email, $list)
    {
    }


}
