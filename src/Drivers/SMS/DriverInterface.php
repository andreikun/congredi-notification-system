<?php namespace Congredi\NotificationSystem\Drivers\SMS;


interface DriverInterface
{
	public function send(SmsMessage $message);
}