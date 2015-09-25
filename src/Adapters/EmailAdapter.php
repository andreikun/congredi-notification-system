<?php namespace Congredi\NotificationSystem\Adapters;

class EmailAdapter
{
	/**
	 * @var
	 */
	protected $mailer;

	/**
	 * @var
	 */
	protected $configs;

	/**
	 * @param $mailer
	 */
	public function setMailer($mailer)
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
	 * @return mixed
	 */
	public function getConfigs()
	{
		return $this->configs;
	}

	/**
	 * @param $configs
	 */
	public function setConfigs($configs)
	{
		$this->configs = $configs;
	}

	public function send($template, $templateData, $emailData)
	{
		$args = func_get_args();

		return call_user_func_array(
			[$this->mailer, 'send'], $args
		);
	}
}