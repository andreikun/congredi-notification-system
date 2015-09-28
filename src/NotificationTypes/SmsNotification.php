<?php namespace Congredi\NotificationSystem\NotificationTypes;

use Congredi\NotificationSystem\NotificationTypes\Abstracts\AbstractNotificationType;

class SmsNotification extends AbstractNotificationType
{
	protected $queueName = 'notifications.sms';
}