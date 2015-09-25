<?php namespace Congredi\NotificationSystem;

use Congredi\NotificationSystem\Adapters\EmailAdapter;
use Congredi\NotificationSystem\Adapters\PushAdapter;
use Congredi\NotificationSystem\Adapters\SmsAdapter;
use Illuminate\Support\ServiceProvider;

class CongrediNotificationsServiceProvider extends ServiceProvider
{
	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerNotificationTypesAdapters();
		$this->registerManager();
	}

	/**
	 * Register notification types.
	 */
	public function registerNotificationTypesAdapters()
	{
		$this->app->bindShared('notification.email.adapter', function ($app) {
			$emailAdapter = new EmailAdapter();

			return $emailAdapter;
		});

		$this->app->bindShared('notification.sms.adapter', function ($app) {
			$smsAdapter = new SmsAdapter();

			return $smsAdapter;
		});

		$this->app->bindShared('notification.push.adapter', function ($app) {
			$pushAdapter = new PushAdapter();

			return $pushAdapter;
		});
	}
	/**
	 * Register Notification System Manager
	 */
	public function registerManager()
	{
		$this->app->singleton('notificationSystem.manager', function ($app) {
			$manager = new NotificationSystemManager($app, $app->make('Illuminate\Contracts\Bus\Dispatcher'));

			return $manager;
		});

		$this->app->singleton(NotificationSystemManager::class, function ($app) {
			return $app['notificationSystem.manager'];
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 * @codeCoverageIgnore
	 */
	public function provides()
	{
		return ['notificationSystem.manager'];
	}
}