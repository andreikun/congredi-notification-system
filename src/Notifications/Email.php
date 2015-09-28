<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\Adapters\EmailAdapter;
use Congredi\NotificationSystem\NotificationTypes\EmailNotification;

class Email extends EmailNotification
{
	/**
	 * @var array From Email Address
	 */
	public $from;

	/**
	 * @var array Sender email Address
	 */
	public $sender;

	/**
	 * @var array to
	 */
	public $to;

	/**
	 * @var array CC
	 */
	public $cc;

	/**
	 * @var array BCC
	 */
	public $bcc;

	/**
	 * @var array ReplyTo
	 */
	public $replyTo;

	/**
	 * @var string Email Subject
	 */
	public $subject;

	/**
	 * @var string Email priority
	 */
	public $priority;

	/**
	 * @var array Email Attachments
	 */
	public $attachments;

	/**
	 * @var string Template Name
	 */
	public $template;

	/**
	 * @var array Email template Data
	 */
	public $templateData;

	public function handle(EmailAdapter $adapter)
	{
		$adapter->send($this);
	}

	public function failed()
	{
		//Called when the job is failing.
	}
}