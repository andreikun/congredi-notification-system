<?php namespace Congredi\NotificationSystem;

use Congredi\NotificationSystem\NotificationTypes\EmailNotification;
use Illuminate\Support\ServiceProvider;

class CongrediNotificationsServiceAdapter extends ServiceProvider
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
		$this->registerNotificationTypes();
		$this->registerManager();
	}

	/**
	 * Register notification types.
	 */
	public function registerNotificationTypes()
	{
		$this->app->bindShared(EmailNotification::class, function ($app) {
			$emailNotification = new EmailNotification();
			$emailNotification->setNotificationService($app->make['mailer']);

			return $emailNotification;
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