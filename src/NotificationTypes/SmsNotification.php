<?php namespace Congredi\NotificationSystem\NotificationTypes;

use Congredi\NotificationSystem\NotificationTypes\Abstracts\AbstractNotificationType;

class SmsNotification extends AbstractNotificationType
{
	protected $queueName = 'notifications.sms';

	/**
	 * @param array $properties Easy way to set attributes at construction
	 */
	public function __construct($properties = [])
	{
		parent::__construct($properties);

		$this->adapter = app()->make('notification.sms.adapter');
	}
}