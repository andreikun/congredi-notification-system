<?php namespace Congredi\NotificationSystem\Adapters;

use Sly\NotificationPusher\PushManager;

class PushAdapter
{
	/**
	 * @var array
	 */
	protected $configs;

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
	protected $pushManager;

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
	 * @param \Sly\NotificationPusher\PushManager $pushManager
	 */
	public function __construct(PushManager $pushManager = null)
	{
		$this->pushManager = $pushManager;
	}

	public function send()
	{

	}
}
