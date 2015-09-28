<?php namespace Congredi\NotificationSystem\NotificationTypes\Abstracts;

use Congredi\NotificationSystem\NotificationTypes\Interfaces\NotificationTypeInterface;

abstract class AbstractNotificationType implements NotificationTypeInterface
{
	/**
	 * Queue name of the notification type.
	 *
	 * @var
	 */
	protected $queueName;

	/**
	 * @param array $properties Easy way to set attributes at construction
	 */
	public function __construct($properties = [])
	{
		foreach ($properties as $name => $value) {
			if (property_exists($this, $name)) {
				$this->{$name} = $value;
			}
		}
	}

	/**
	 * Returns the fully qualified name of this class.
	 *
	 * @return string the fully qualified name of this class.
	 */
	public static function className()
	{
		return static::class;
	}

	/**
	 * @return mixed
	 */
	public function getQueueName()
	{
		return $this->queueName;
	}

	/**
	 * @param $name
	 *
	 * @return void
	 */
	public function setQueueName($name)
	{
		$this->queueName = $name;
	}
}