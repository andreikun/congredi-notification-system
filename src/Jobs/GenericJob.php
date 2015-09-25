<?php namespace Congredi\NotificationSystem\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Congredi\NotificationSystem\NotificationTypes\Interfaces\NotificationTypeInterface;
use Illuminate\Contracts\Foundation\Application;

class GenericJob implements SelfHandling, ShouldQueue
{
	use InteractsWithQueue, Queueable, SerializesModels;

	protected $notification;

	/**
	 * Create a new job instance.
	 *
	 * @param \Congredi\NotificationSystem\NotificationTypes\Interfaces\NotificationTypeInterface $notification
	 */
	public function __construct(NotificationTypeInterface $notification)
	{
		$this->notification = $notification;
	}

	/**
	 * @param \Illuminate\Contracts\Foundation\Application $app
	 */
	public function handle(Application $app)
	{
		$app->call([$this->notification, 'handle']);
	}
}