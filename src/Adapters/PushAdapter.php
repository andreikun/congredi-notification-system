<?php namespace Congredi\NotificationSystem\Adapters;

use Congredi\NotificationSystem\Providers\PushNotification;

class PushAdapter
{
	/**
	 * @var string
	 */
	protected $adapterType = 'apns';

	/**
	 * @var array
	 */
	protected $tokens = [];

	/**
	 * @var array
	 */
	protected $messageData = [];

	/**
	 * @var
	 */
	protected $pushNotification;

	/**
	 * @param $tokens
	 */
	public function setTokens($tokens)
	{
		$this->tokens = $tokens;
	}

	/**
	 * @param $messageData
	 */
	public function setMessageData($messageData)
	{
		$this->messageData = $messageData;
	}

	/**
	 * @param $type
	 */
	public function setAdapterType($type)
	{
		$this->adapterType = $type;
	}

	/**
	 * @param $pushNotification
	 */
	public function __construct($pushNotification)
	{
		$this->pushNotification = $pushNotification;
	}

	/**
	 * Send Push Notification
	 */
	public function send()
	{
		$args = [];
		foreach($this->tokens as $token) {
			$args[] = PushNotification::Device($token);
		}

		$devices = call_user_func_array([PushNotification::class, 'DeviceCollection'], $args);

		$messageText = (!empty($this->messageData['text'])) ? $this->messageData['text'] : '';

		$messageOptions = (!empty($this->messageData['options'])) ? $this->messageData['options'] : [];

		$message = PushNotification::Message($messageText, $messageOptions);

		$this->pushNotification->app(implode("_", [$this->adapterType, app()->environment()]))
			->to($devices)
			->send($message);

		return true;
	}
}
