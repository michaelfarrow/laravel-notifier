<?php namespace Weyforth\Notifier;

interface NotifierInterface
{

    public function notify(
        NotfierUserInterface $user,
        $subject,
        $view,
        $data = array()
    );
    public function subscribe($email, $list);
    
}