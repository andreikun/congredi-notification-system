<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\NotificationTypes\EmailNotification;

class Email extends EmailNotification
{
	public function handle()
	{
		var_dump("Here should be sent an email address");
	}
}