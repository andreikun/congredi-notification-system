<?php

/*
    |--------------------------------------------------------------------------
    | SMS Settings
    |--------------------------------------------------------------------------
    | Driver
    |   Email:  The Email driver uses the Illuminate\Mail\Mailer instance to
    |           send SMS messages based on the carriers e-mail to SMS gateways.
	|   Twilio: https://www.twilio.com/
    |--------------------------------------------------------------------------
    | From
    |   Email:  The from address must be a valid email address.
    |   Twilio: The from address must be a verified phone number within Twilio.
    |--------------------------------------------------------------------------
    | Twilio Additional Settings
    |   Account SID:  The Account SID associated with your Twilio account.
    |   Auth Token:   The Auth Token associated with your Twilio account.

*/

return [
	'driver' => 'Put your own driver',
	'from' => 'Put your own phone number or email address',
	'twilio' => [
		'account_sid' => 'Your SID',
		'auth_token' => 'Your Token',
	],
];