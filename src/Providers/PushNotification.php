<?php namespace Congredi\NotificationSystem\Providers;

use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\PushManager;
use Sly\NotificationPusher\Model\Device;

class PushNotification
{
	/**
	 * This Class is a wrapper around NotificationPusher Library from GitHub
	 *
	 * https://github.com/Ph3nol/NotificationPusher
	 *
	 * This class can be used in the same manner NotificationPusher is used, just that the class providers
	 * some flavor to it, and some convenient ways to cascade methods and make push notification sending even easier.
	 *
	 * Example: (new PushNotification($configs))->app($appName)->to($devices)->send($message);
	 *
	 * Class PushNotification
	 *
	 * @package Congredi\NotificationSystem\Providers
	 */

	/**
	 * @var \Sly\NotificationPusher\Adapter\AdapterInterface
	 */
	protected $adapter;

	/**
	 * @var \Sly\NotificationPusher\Model\DeviceInterface
	 */
	protected $addresses;

	/**
	 * @var array
	 */
	protected $configs;

	/**
	 * @var \Sly\NotificationPusher\PushManager
	 */
	protected $pushManager;

	/**
	 * @var \Sly\NotificationPusher\Model\MessageInterface
	 */
	protected $message;

	/**
	 * Push Notification constructor. Here we can se parameters.
	 *
	 * @param $configs
	 */
	public function __construct($configs)
	{
		$this->configs = $configs;
	}

	/**
	 * Create a new push notification instance.
	 *
	 * @param $pushConfigs
	 * @return $this
	 */
	public function app($pushConfigs)
	{
		$defaultConfigs = [
			'service' => 'apns',
			'environment' => 'production'
		];

		$config = $pushConfigs;

		if (is_string($pushConfigs)) {
			$config = (isset($this->configs[$pushConfigs])) ? $this->configs[$pushConfigs] : $defaultConfigs;
		}

		$this->pushManager = new PushManager($config['environment'] == "development"
			? PushManager::ENVIRONMENT_DEV : PushManager::ENVIRONMENT_PROD);

		$baseAdapter = new \ReflectionClass(AdapterInterface::class);

		$adapterClassName = $baseAdapter->getNamespaceName() . '\\' . ucfirst($config['service']);

		$this->adapter = new $adapterClassName($config['options']);

		return $this;
	}

	/**
	 * Attach addresses for push notification
	 *
	 * @param $addressee
	 * @return $this
	 */
	public function to($addressee)
	{
		$this->addresses = is_string($addressee) ? new Device($addressee) : $addressee;

		return $this;
	}

	/**
	 * Send Push Notification
	 *
	 * @param $message
	 * @param array $options
	 * @return $this
	 */
	public function send($message, $options = array()) {
		//Build Message
		$this->message =  ($message instanceof Message) ? $message : new Message($message, $options);

		//Create Push
		$push = new Push($this->adapter, $this->addresses, $this->message);

		//Add Push to Manager
		$this->pushManager->add($push);

		//Send Notification
		$this->pushManager->push();

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFeedback() {
		return $this->pushManager->getFeedback($this->adapter);
	}

	/**
	 * Create a new Push Notification Message
	 *
	 * @return object
	 */
	public static function Message()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\Model\Message'));

		return $instance->newInstanceArgs(func_get_args());
	}

	/**
	 * Create a new push notification device.
	 *
	 * @return object
	 */
	public static function Device()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\Model\Device'));

		return $instance->newInstanceArgs(func_get_args());
	}

	/**
	 * Create multiple push notifications devices.
	 *
	 * @return object
	 */
	public static function DeviceCollection()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\Collection\DeviceCollection'));

		return $instance->newInstanceArgs(func_get_args());
	}

	/**
	 * Create a new PushManager for Push Notifications
	 *
	 * @return object
	 */
	public static function PushManager()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\PushManager'));

		return $instance->newInstanceArgs(func_get_args());
	}

	/**
	 * Create a new APNS adapter to send push notifications
	 *
	 * @return object
	 */
	public static function ApnsAdapter()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\Adapter\ApnsAdapter'));

		return $instance->newInstanceArgs(func_get_args());
	}

	/**
	 * Create a new GCM adpater to send push notifications
	 *
	 * @return object
	 */
	public static function GcmAdapter()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\Model\GcmAdapter'));

		return $instance->newInstanceArgs(func_get_args());
	}

	/**
	 * Create a new push for push notifications
	 *
	 * @return object
	 */
	public static function Push()
	{
		$instance = (new \ReflectionClass('Sly\NotificationPusher\Model\Push'));

		return $instance->newInstanceArgs(func_get_args());
	}

}