<?php namespace Congredi\Notifications\NotificationTypes;

use Congredi\Notifications\NotificationTypes\Abstracts\AbstractNotificationType;

class Sms extends AbstractNotificationType
{
	/**
	 * Method used to handle Sms notification
	 */
	public function handle()
	{
		var_dump("Hello from sms notification");
	}
}