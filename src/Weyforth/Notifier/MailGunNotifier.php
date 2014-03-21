<?php
/**
 * MailGun notifier.
 *
 * @author    Mike Farrow <contact@mikefarrow.co.uk>
 * @license   Proprietary/Closed Source
 * @copyright Mike Farrow
 */

namespace Weyforth\Notifier;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Mailgun\Mailgun;

class MailGunNotifier implements NotifierInterface
{

    /**
     * The MailGun API.
     *
     * @var MailGun
     */
    protected $mailgun;


    /**
     * Sets up MailGun API.
     */
    public function __construct()
    {
        $this->mailgun = new Mailgun(Config::get('notifier::mailgun.key.secret'));
    }


    /**
     * {@inheritdoc}
     */
    public function notify(
        NotfierUserInterface $user,
        $subject,
        $view,
        $data = array()
    ) {
        $domain  = Config::get('notifier::mailgun.domain');
        $name    = Config::get('notifier::name');
        $address = Config::get('notifier::address');

        $result = $this->mailgun->sendMessage(
            $domain,
            array(
                'from' => $name.' <'.$address.'>',
                'to' => $user->emailAddress(),
                'subject' => $subject,
                'html' => View::make($view)->with(
                    array_merge($data, compact('user'))
                )->render(),
            )
        );
    }


    /**
     * {@inheritdoc}
     */
    public function subscribe($email, $list)
    {
        $domain      = Config::get('notifier::mailgun.domain');
        $membersList = 'lists/'.$list.'@'.$domain.'/members';

        try {
            try {
                $result = $this->mailgun->get($membersList.'/'.$email);
            } catch (\Exception $e) {
                $result = false;
            }

            if ($result
                && isset($result->http_response_code)
                && isset($result->http_response_body)
                && $result->http_response_code == 200
                && !$result->http_response_body->member->subscribed
            ) {
                $result = $this->mailgun->put(
                    $membersList.'/'.$email,
                    array(
                        'subscribed' => true
                    )
                );
            } else {
                $result = $this->mailgun->post(
                    $membersList,
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
        } catch (\Exception $e) {
            return false;
        }
    }


}
