<?php namespace Congredi\NotificationSystem\NotificationTypes;

use Congredi\NotificationSystem\NotificationTypes\Abstracts\AbstractNotificationType;

class EmailNotification extends AbstractNotificationType
{
	protected $queueName = 'notifications.email';

	/**
	 * @param array $properties Easy way to set attributes at construction
	 */
	public function __construct($properties = [])
	{
		parent::__construct($properties);

		$this->adapter = app()->make('notification.email.adapter');
	}
}