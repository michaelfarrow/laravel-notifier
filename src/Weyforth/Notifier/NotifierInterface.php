<?php
/**
 * Notifier interface.
 *
 * Notifiers must implement this interface.
 * Provides common functions to notify a user and subscribe to lists.
 *
 * @author    Mike Farrow <contact@mikefarrow.co.uk>
 * @license   Proprietary/Closed Source
 * @copyright Mike Farrow
 */

namespace Weyforth\Notifier;

interface NotifierInterface
{


    /**
     * Creates and sends an email using a view template and supplied data.
     *
     * User object will be send to the view along with the supplied
     * data as a $user variable.
     *
     * @param NotfierUserInterface $user    User to notify.
     * @param string               $subject Email subject.
     * @param string               $view    Email view template.
     * @param array                $data    Data to send to view.
     *
     * @return void
     */
    public function notify(
        NotifierUserInterface $user,
        $subject,
        $view,
        array $data = array()
    );


    /**
     * Subscribe an email to a mailing list.
     *
     * @param string $email Email address.
     * @param string $list  List to subscribe the email to.
     *
     * @return void
     */
    public function subscribe($email, $list);


}
