<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\Adapters\SmsAdapter;
use Congredi\NotificationSystem\NotificationTypes\SmsNotification as SmsNotificationType;

class SMS extends SmsNotificationType
{
	/**
	 * @var array From Email Address
	 */
	public $from;

	/**
	 * @var array Receivers
	 */
	public $receivers;

	/*
	 * @var array Attachments
	 */
	public $attachments;

	/**
	 * @var string Raw message
	 */
	public $message;

	/**
	 * @var array MessageData
	 */
	public $messageData;

	/**
	 * @var boolean
	 */
	public $pretending = false;

	public function handle(SmsAdapter $adapter)
	{
		$adapter->send($this);
	}

	public function failed()
	{
		//Called when the job is failing.
	}
}