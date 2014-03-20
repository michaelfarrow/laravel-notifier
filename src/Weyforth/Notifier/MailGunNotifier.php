<?php namespace Weyforth\Notifier;

use User;
use View;
use Config;
use Mailgun\Mailgun;

class MailGunNotifier implements NotifierInterface
{

    protected $mailgun;

    public function __construct()
    {
        $this->mailgun = new Mailgun(Config::get('notifier.mailgun.key.secret'));
    }

    public function notify(User $user, $subject, $view, $data = array())
    {
        $domain = Config::get('notifier.mailgun.domain');

        $result = $this->mailgun->sendMessage(
            $domain,
            array(
                'from' => Config::get('notifier.name')
                          .' <'
                          .Config::get('notifier.address')
                          .'>',
                'to' => $user->email,
                'subject' => $subject,
                'html' => View::make($view)->with(
                    array_merge($data, compact('user'))
                )->render(),
            )
        );
    }

    public function subscribe($email, $list)
    {
        $domain = Config::get('notifier.mailgun.domain');

        try{
            try{
                $result = $this->mailgun->get("lists/$list@$domain/members/$email");
            }catch(\Exception $e){
                $result = false;
            }

            if ($result
                && isset($result->http_response_code)
                && isset($result->http_response_body)
                && $result->http_response_code == 200
                && !$result->http_response_body->member->subscribed
            ) {
                $result = $this->mailgun->put(
                    "lists/$list@$domain/members/$email",
                    array(
                        'subscribed' => true
                    )
                );
            } else {
                $result = $this->mailgun->post(
                    "lists/$list@$domain/members",
                    array(
                        'address' => $email,
                        'subscribed' => true
                    )
                );
            }

            if ($result
                && isset($result->http_response_code)
                && $result->http_response_code == 200
            ) {
                return true;
            } else {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }
    }

}