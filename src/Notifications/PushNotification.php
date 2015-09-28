<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\Adapters\PushAdapter;
use Congredi\NotificationSystem\NotificationTypes\PushNotification as BasePushNotification;

class PushNotification extends BasePushNotification
{
	/**
	 * @var
	 */
	public $type;

	/**
	 * @var array
	 */
	public $tokens = [];

	/**
	 * @var string
	 */
	public $message;

	/**
	 * @param \Congredi\NotificationSystem\Adapters\PushAdapter $adapter
	 */
	public function handle(PushAdapter $adapter)
	{
		$adapter->setAdapterType($this->type);
		$adapter->setTokens($this->tokens);
		$adapter->setMessageData($this->message);

		$adapter->send();
	}

	/**
	 *
	 */
	public function failed()
	{
		//Called when the job is failing.
	}
}