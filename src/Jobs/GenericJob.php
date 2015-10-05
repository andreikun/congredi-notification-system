<?php namespace Congredi\NotificationSystem\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Congredi\NotificationSystem\NotificationTypes\Interfaces\NotificationTypeInterface;
use Illuminate\Support\Facades\App;

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
	 * Method call when handle job.
	 */
	public function handle()
	{
		App::call([$this->notification, 'handle']);
	}

	/**
	 * Called when job failed.
	 */
	public function failed()
	{
		App::call([$this->notification, 'failed']);
	}
}