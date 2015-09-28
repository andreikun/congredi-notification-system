<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\Adapters\EmailAdapter;
use Congredi\NotificationSystem\NotificationTypes\EmailNotification;

class Email extends EmailNotification
{
	/**
	 * @var array From Email Address
	 */
	protected $from;

	/**
	 * @var array Sender email Address
	 */
	protected $sender;

	/**
	 * @var array to
	 */
	protected $to;

	/**
	 * @var array CC
	 */
	protected $cc;

	/**
	 * @var array BCC
	 */
	protected $bcc;

	/**
	 * @var array ReplyTo
	 */
	protected $replyTo;

	/**
	 * @var string Email Subject
	 */
	protected $subject;

	/**
	 * @var string Email priority
	 */
	protected $priority;

	/**
	 * @var array Email Attachments
	 */
	protected $attachments;

	/**
	 * @var string Template Name
	 */
	protected $template;

	/**
	 * @var array Email template Data
	 */
	protected $templateData;

	public function handle(EmailAdapter $adapter)
	{
		$adapter->send($this);
	}

	public function failed()
	{
		//Called when the job is failing.
	}
}