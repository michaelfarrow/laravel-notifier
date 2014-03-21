<?php

use \Illuminate\Support\Facades\Config;
use \Weyforth\Notifier\NotifierServiceProvider;
use \Weyforth\Notifier\NotifierUserInterface;
use \Weyforth\Notifier\MailGunNotifier;
use \Weyforth\Notifier\EmailNotifier;
use \Mockery;

class GeneralTest extends PHPUnit_Framework_Testcase
{

    public function testServiceProvider(){
        $app = Mockery::mock('Illuminate\Foundation\Application');
        $sp = new NotifierServiceProvider($app);
    }

    public function testMailGunNotifier(){
        $config = new Config;
        $config->shouldReceive('get');

        $notifier = new MailGunNotifier();

        $this->assertInstanceOf('\Weyforth\Notifier\NotifierInterface', $notifier);
        $this->assertInstanceOf('\Weyforth\Notifier\MailGunNotifier', $notifier);
    }

    public function testEmailNotifier(){
        $config = new Config;

        $notifier = new EmailNotifier();

        $this->assertInstanceOf('\Weyforth\Notifier\NotifierInterface', $notifier);
        $this->assertInstanceOf('\Weyforth\Notifier\EmailNotifier', $notifier);
    }

    public function testUserInterface(){
        $user = new TestUser();
        $this->assertInstanceOf('\Weyforth\Notifier\NotifierUserInterface', $user);
        $this->assertEquals('test@test.com', $user->emailAddress());
    }

}


class TestUser implements NotifierUserInterface
{

    public function emailAddress(){
        return 'test@test.com';
    }

}