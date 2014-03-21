<?php
/**
 * Notifier Service Provider.
 *
 * Provides interface to operate using
 * multiple notifier services inc. Email and MailGun.
 *
 * @author    Mike Farrow <contact@mikefarrow.co.uk>
 * @license   Proprietary/Closed Source
 * @copyright Mike Farrow
 */

namespace Weyforth\Notifier;

use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('weyforth/notifier');
    }


    /**
     * Register the default interface to use for dependency injection.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind(
            'Weyforth\Notifier\NotifierInterface',
            'Weyforth\Notifier\MailGunNotifier'
        );
    }


}
