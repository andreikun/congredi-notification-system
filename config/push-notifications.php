<?php

return [
	'IOS' => [
		'environment' =>'production',
		'certificate' =>'/path/to/certificate.pem',
		'passPhrase'  =>'password',
		'service'     =>'apns'
	],
	'Android' => [
		'environment' =>'production',
		'apiKey'      =>'yourAPIKey',
		'service'     =>'gcm'
	]
];