<?php namespace Congredi\Notifications\NotificationTypes;

use Congredi\Notifications\NotificationTypes\Abstracts\AbstractNotificationType;

class Push extends AbstractNotificationType
{
	/**
	 * Method used to handle push notification
	 */
	public function handle()
	{
		var_dump("Hello from Push notification");
	}
}