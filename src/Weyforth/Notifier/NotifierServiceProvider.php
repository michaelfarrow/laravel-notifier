<?php namespace Weyforth\Notifier;

use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{

    public function register()
    {
        $app = $this->app;

        $app->bind(
            'Weyforth\Notifier\NotifierInterface',
            'Weyforth\Notifier\MailGunNotifier'
        );
    }

}
