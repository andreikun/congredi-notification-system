<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\NotificationTypes\EmailNotification;

class Email extends EmailNotification
{
	public function handle()
	{
		var_dump(get_class($this->getAdapter()));
		var_dump($this->adapter->getConfigs());
		var_dump($this->getQueueName());
		var_dump("Here should be sent an email address");
	}
}