<?php namespace Congredi\NotificationSystem;


interface NotificationSystemInterface
{
	/**
	 * Method used to send an notification
	 *
	 * @param $className
	 * @param $parameters
	 * @return mixed
	 */
	public function send($className, $parameters);
}