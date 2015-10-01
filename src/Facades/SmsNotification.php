<?php namespace Congredi\NotificationSystem\Facades;

use Illuminate\Support\Facades\Facade;

class SmsNotification extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'sms.notification';
	}
}