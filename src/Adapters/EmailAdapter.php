<?php namespace Congredi\NotificationSystem\Adapters;

use Congredi\NotificationSystem\Notifications\Email;
use Illuminate\Contracts\Mail\Mailer;

class EmailAdapter
{
	/**
	 * @var
	 */
	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * @return mixed
	 */
	public function getMailer()
	{
		return $this->mailer;
	}

	/**
	 * @param $mailer
	 */
	public function setMailer($mailer)
	{
		$this->mailer = $mailer;
	}

	public function send(Email $emailData)
	{
		$this->mailer->send($emailData->template, $emailData->templateData, function ($message) use ($emailData) {
			if (!empty($emailData->from)) {
				$message->from(
					$emailData->from['address'],
					(isset($emailData->from['name']) ? $emailData->from['name'] : null)
				);
			}

			if (!empty($emailData->sender)) {
				$message->sender(
					$emailData->sender['address'],
					(isset($emailData->sender['name']) ? $emailData->sender['name'] : null)
				);
			}

			if (!empty($emailData->to)) {
				$message->to(
					$emailData->to['address'],
					(isset($emailData->to['name']) ? $emailData->to['name'] : null)
				);
			}

			if (!empty($emailData->cc)) {
				$message->cc(
					$emailData->cc['address'],
					(isset($emailData->cc['name']) ? $emailData->cc['name'] : null)
				);
			}

			if (!empty($emailData->bcc)) {
				$message->bcc(
					$emailData->bcc['address'],
					(isset($emailData->bcc['name']) ? $emailData->bcc['name'] : null)
				);
			}

			if (!empty($emailData->replyTo)) {
				$message->replyTo(
					$emailData->replyTo['address'],
					(isset($emailData->replyTo['name']) ? $emailData->replyTo['name'] : null)
				);
			}

			if (!empty($emailData->subject)) {
				$message->subject($emailData->subject);
			}

			if (!empty($emailData->priority)) {
				$message->priority($emailData->priority);
			}

			if (!empty($emailData->attachments) && count($emailData->attachments) > 0) {
				foreach ($emailData->attachments as $attachment) {
					if (isset($attachment['pathToFile'])) {
						$message->attach(
							$attachment['pathToFile'],
							(isset($attachment['options'])) ? isset($attachment['options']) : array()
						);
					}
					else {
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
}