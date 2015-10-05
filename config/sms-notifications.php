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
	'driver' => 'clickatell',
	'from' => '+15005550006',
	'twilio' => [
        'account_sid' => 'AC0cdecfe1ac6122a004f27b98dec15e87',
        'auth_token' => 'ecbb711d5eb830d52015b331f99ac3b1',
	],
    'clickatell' => [
        'username' => 'kunandrei',
        'password' => 'HJiu65r',
        'app_id' => '3565578'
    ],
    'cmsms' => [
        'product_token' => '04a7f1bb-fe5b-4159-9e43-6818961541d0'
    ]
];