<?php namespace Congredi\NotificationSystem;

use Clickatell\Api\ClickatellHttp;
use Congredi\NotificationSystem\Adapters\EmailAdapter;
use Congredi\NotificationSystem\Adapters\PushAdapter;
use Congredi\NotificationSystem\Adapters\SmsAdapter;
use Congredi\NotificationSystem\Drivers\SMS\ClickatellSMS;
use Congredi\NotificationSystem\Drivers\SMS\CMSMSGateway;
use Congredi\NotificationSystem\Drivers\SMS\EmailSMS;
use Congredi\NotificationSystem\Drivers\SMS\TwillioSMS;
use Congredi\NotificationSystem\Providers\SMSNotification;
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
		/**
		 * Push Notifications Settings
		 */
		$source = realpath(__DIR__ . '/../config/push-notifications.php');

		if (class_exists('Illuminate\Foundation\Application', false)) {
			$this->publishes([$source => config_path('push-notifications.php')]);
		}

		$this->mergeConfigFrom($source, 'push-notifications');

		/**
		 * SMS Notifications Settings.
		 */
		$source = realpath(__DIR__ . '/../config/sms-notifications.php');

		if (class_exists('Illuminate\Foundation\Application', false)) {
			$this->publishes([$source => config_path('sms-notifications.php')]);
		}

		$this->mergeConfigFrom($source, 'sms-notifications');
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
		$this->app->bindShared('push.notification', function ($app) {
			return new PushNotification($app['config']->get('push-notifications'));
		});

		$this->app->bindShared('sms.notification', function ($app) {
			$configs = $app['config']->get('sms-notifications');

			$driver = $this->detectSMSSender($configs);

			$smsInstance = new SMSNotification($driver);

			$smsInstance->setContainer($app);
			$smsInstance->setConfigs($configs);
			$smsInstance->setLogger($app['log']);

			return $smsInstance;
		});
	}

	/**
	 * @param $config
	 * @return \Congredi\NotificationSystem\Drivers\SMS\EmailSMS
	 */
	protected function detectSMSSender($config)
	{
		$driver = (isset($config['driver'])) ? $config['driver'] : 'email';

		switch ($driver) {
			case 'email':
				return new EmailSMS($this->app->make('mailer'));
			case 'twilio':
				$twilioClient = new \Services_Twilio(
					$config['twilio']['account_sid'],
					$config['twilio']['auth_token']
				);

				return new TwillioSMS($twilioClient);
			case 'clickatell':
				$clickatell = new ClickatellHttp(
					$config['clickatell']['username'],
					$config['clickatell']['password'],
					$config['clickatell']['app_id']
				);

				return new ClickatellSMS($clickatell);
			case 'cmsms':
				return new CMSMSGateway($config['cmsms']['product_token']);
			default:
				throw new \InvalidArgumentException('Invalid SMS Driver.');
		}
	}

	/**
	 * Register notification types.
	 */
	public function registerNotificationTypesAdapters()
	{
		$this->app->bindShared(EmailAdapter::class, function ($app) {
			$emailAdapter = new EmailAdapter($app->make('mailer'));

			return $emailAdapter;
		});

		$this->app->bindShared(SmsAdapter::class, function ($app) {
			$smsAdapter = new SmsAdapter($app->make('sms.notification'));

			return $smsAdapter;
		});

		$this->app->bindShared(PushAdapter::class, function ($app) {
			$pushAdapter = new PushAdapter($app->make('push.notification'));

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