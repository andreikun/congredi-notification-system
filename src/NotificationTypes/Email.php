<?php namespace Congredi\Notifications\NotificationTypes;

use Congredi\Notifications\NotificationTypes\Abstracts\AbstractNotificationType;

class Email extends AbstractNotificationType
{
	/**
	 * Method used to handle email notification
	 */
	public function handle()
	{
		var_dump("Hello from email notification");
	}
}