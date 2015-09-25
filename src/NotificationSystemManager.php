<?php namespace Congredi\NotificationSystem;

use Congredi\NotificationSystem\Exceptions\InvalidNotificationTypeException;
use Congredi\NotificationSystem\NotificationTypes\Abstracts\AbstractNotificationType;
use Congredi\NotificationSystem\Traits\DispatchTrait;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Congredi\NotificationSystem\Jobs\GenericJob;

class NotificationSystemManager implements NotificationSystemInterface
{
	use DispatchTrait;

	/**
	 * @var \Illuminate\Contracts\Bus\Dispatcher
	 */
	protected $dispatcher;

	/**
	 * The application instance.
	 *
	 * @var \Illuminate\Contracts\Foundation\Application
	 */
	protected $app;

	/**
	 * @param \Illuminate\Contracts\Foundation\Application $app
	 * @param \Illuminate\Contracts\Bus\Dispatcher $dispatcher
	 */
	public function __construct(Application $app, Dispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
		$this->app = $app;
	}

	/**
	 * Send notification
	 *
	 * @param $className
	 * @param array $parameters
	 * @return bool
	 * @throws \Congredi\NotificationSystem\Exceptions\InvalidNotificationTypeException
	 */
	public function send($className, $parameters = array())
	{
		if (!class_exists($className)) {
			throw new InvalidNotificationTypeException();
		}

		$class = new \ReflectionClass($className);
		if (! $class->isSubclassOf(AbstractNotificationType::className())) {
			throw new InvalidNotificationTypeException();
		}

		//Setup a new instance of $className class and pass $parameters
		$notificationTypeInstance = new $className($parameters);

		//Create a new instance of a general generic Job.
		$job = new GenericJob($notificationTypeInstance);

		$this->dispatch($job);

		return true;
	}
}