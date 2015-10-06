<?php namespace Congredi\NotificationSystem\Traits;

use Mockery;
use Congredi\NotificationSystem\Jobs\GenericJob;

trait NotificationTestsTrait
{
	/**
	 * Specify a list of notification types that should be dispatched for the given operation.
	 *
	 * These notifications will be mocked, so that handlers will not actually be executed.
	 *
	 * @param $notificationType
	 * @return $this
	 */
	protected function expectsNotifications($notificationType)
	{
		//As a fix for Lumen, we need to clear bindings for Displatcher in order to be able to mock this
		//using Mockery.
		unset ($this->app->availableBindings['Illuminate\Contracts\Bus\Dispatcher']);

		$mock = Mockery::mock('Illuminate\Bus\Dispatcher[dispatch]', [$this->app]);

		$mock->shouldReceive('dispatch')->atLeast()->once()
			->with(Mockery::on(function($called) use ($notificationType) {

				//Assert the generic job has a notification and it has the right type.
				$this->assertInstanceOf(GenericJob::class, $called);
				$this->assertObjectHasAttribute('notification', $called);
				$this->assertInstanceOf($notificationType, $this->readAttribute($called, 'notification'));

				return true;
			}));

		$this->app->instance(
			'Illuminate\Contracts\Bus\Dispatcher', $mock
		);

		return $this;
	}
}