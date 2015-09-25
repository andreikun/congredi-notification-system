<?php namespace Congredi\NotificationSystem\Notifications;

use Congredi\NotificationSystem\NotificationTypes\EmailNotification;
use Illuminate\Contracts\Mail\Mailer;

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

	public function handle(Mailer $mailer)
	{
		$mailer->send($this->template, $this->templateData, function($message) {
			if (!empty($this->from)) {
				$message->from(
					$this->from['address'],
					(isset($this->from['name']) ? $this->from['name'] : null)
				);
			}

			if (!empty($this->sender)) {
				$message->sender(
					$this->sender['address'],
					(isset($this->sender['name']) ? $this->sender['name'] : null)
				);
			}

			if (!empty($this->to)) {
				$message->to(
					$this->to['address'],
					(isset($this->to['name']) ? $this->to['name'] : null)
				);
			}

			if (!empty($this->cc)) {
				$message->cc(
					$this->cc['address'],
					(isset($this->cc['name']) ? $this->cc['name'] : null)
				);
			}

			if (!empty($this->bcc)) {
				$message->bcc(
					$this->bcc['address'],
					(isset($this->bcc['name']) ? $this->bcc['name'] : null)
				);
			}

			if (!empty($this->replyTo)) {
				$message->replyTo(
					$this->replyTo['address'],
					(isset($this->replyTo['name']) ? $this->replyTo['name'] : null)
				);
			}

			if (!empty($this->subject)) {
				$message->subject($this->subject);
			}

			if (!empty($this->priority)) {
				$message->priority($this->priority);
			}

			if (!empty($this->attachments) && count($this->attachments) > 0) {
				foreach ($this->attachments as $attachment) {
					if (isset($attachment['pathToFile'])) {
						$message->attach(
							$attachment['pathToFile'],
							(isset($attachment['options'])) ? isset($attachment['options']) : array()
						);
					} else {
						$message->attachData(
							$attachment['data'],
							$attachment['name'],
							(isset($attachment['options'])) ? isset($attachment['options']) : array()
						);
					}
				}
			}
		});
	}

	public function failed()
	{
		//Called when the job is failing.
	}
}