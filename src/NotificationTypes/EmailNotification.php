<?php namespace Congredi\NotificationSystem\NotificationTypes;

use Congredi\NotificationSystem\NotificationTypes\Abstracts\AbstractNotificationType;

class EmailNotification extends AbstractNotificationType
{
	protected $queueName = 'notifications.email';
}