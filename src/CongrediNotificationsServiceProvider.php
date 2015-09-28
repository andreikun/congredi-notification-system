<?php namespace Congredi\NotificationSystem;

use Congredi\NotificationSystem\Adapters\EmailAdapter;
use Congredi\NotificationSystem\Adapters\PushAdapter;
use Congredi\NotificationSystem\Adapters\SmsAdapter;
use Illuminate\Support\ServiceProvider;
use Congredi\NotificationSystem\Providers\PushNotification;

class CongrediNotificationsServiceProvider extends ServiceProvider
{
	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig();
	}

	/**
	 * Setup the config.
	 *
	 * @return void
	 */
	protected function setupConfig()
	{
		$source = realpath(__DIR__ . '/../config/push-notifications.php');

		if (class_exists('Illuminate\Foundation\Application', false)) {
			$this->publishes([$source => config_path('push-notifications.php')]);
		}

		$this->mergeConfigFrom($source, 'push-notifications');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerProviders();
		$this->registerNotificationTypesAdapters();
		$this->registerManager();
	}

	/**
	 * Register Providers.
	 */
	public function registerProviders()
	{
		$this->app->bindShared('push.notification', function($app) {
			return new PushNotification($app['config']->get('push-notifications'));
		});
	}

	/**
	 * Register notification types.
	 */
	public function registerNotificationTypesAdapters()
	{
		$this->app->bindShared(EmailAdapter::class, function ($app) {
			$emailAdapter = new EmailAdapter($app->make('mailer'), $app['config']->get('mail'));

			return $emailAdapter;
		});

		$this->app->bindShared(SmsAdapter::class, function () {
			$smsAdapter = new SmsAdapter();

			return $smsAdapter;
		});

		$this->app->bindShared(PushAdapter::class, function ($app) {
			$pushAdapter = new PushAdapter($app->make['push.notification']);

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