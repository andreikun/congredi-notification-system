<?php namespace Congredi\NotificationSystem\Providers;

use Congredi\NotificationSystem\Drivers\SMS\DriverInterface;
use Congredi\NotificationSystem\Drivers\SMS\SmsMessage;
use Illuminate\Container\Container;
use Illuminate\Log\Writer;

class SMSNotification
{
	/**
	 * @var array
	 */
	protected $configs;

	/**
	 * @var \Congredi\NotificationSystem\Drivers\SMS\DriverInterface;
	 */
	protected $driver;

	/**
	 * @var \Illuminate\Log\Writer;
	 */
	protected $logger;

	/**
	 * Determines if a message should be sent or faked.
	 *
	 * @var boolean
	 */
	protected $pretending = false;

	/**
	 * The IOC Container
	 *
	 * @var \Illuminate\Container\Container
	 */
	protected $container;

	/**
	 * Creates the SMS instance.
	 *
	 * @param DriverInterface $driver
	 */
	public function __construct(DriverInterface $driver)
	{
		$this->driver = $driver;
	}

	/**
	 * Returns if the message should be faked when sent or not.
	 *
	 * @return boolean
	 */
	public function isPretending()
	{
		return $this->pretending;
	}

	/**
	 * Fake sending a SMS
	 *
	 * @param $view
	 * @param $data
	 * @param $callback
	 */
	public function pretend($view, $data, $callback)
	{
		$this->isPretending = true;

		$this->send($view, $data, $callback);
	}

	/**
	 * Send a SMS
	 *
	 * @param $view
	 * @param $data
	 * @param $callback
	 * @return $this
	 */
	public function send($view, $data, $callback)
	{
		$message = $this->buildSMSMessage();

		$message->view($view);
		$message->data(array_merge($data, ['message' => $message]));

		call_user_func($callback, $message);

		if (!$this->pretending) {
			$this->driver->send($message);

			return $this;
		}

		if (isset($this->logger)) {
			$numbers = implode(" , ", $message->getTo());
			$this->logger->info("Pretending to send SMS message to: $numbers");
		}

		return $this;
	}

	/**
	 * @return \Congredi\NotificationSystem\Drivers\SMS\SmsMessage
	 */
	protected function buildSMSMessage()
	{
		$message = new SmsMessage($this->container['view']);

		if (isset($this->configs['from'])) {
			$message->from($this->configs['from']);
		}

		return $message;
	}

	/**
	 * Sets the IoC container
	 *
	 * @param Container $container
	 */
	public function setContainer(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Set the log writer instance.
	 *
	 * @param \Illuminate\Log\Writer $logger
	 * @return $this
	 */
	public function setLogger(Writer $logger)
	{
		$this->logger = $logger;

		return $this;
	}

	/**
	 * @param $configs
	 * @return $this
	 */
	public function setConfigs($configs)
	{
		$this->configs = $configs;

		return $this;
	}
}