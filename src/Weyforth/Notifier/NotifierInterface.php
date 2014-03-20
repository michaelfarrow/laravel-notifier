<?php namespace Weyforth\Notifier;

use User;

interface NotifierInterface
{

    public function notify(User $user, $subject, $view, $data = array());
    public function subscribe($email, $list);
    
}