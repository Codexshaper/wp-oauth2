<?php

return [
	'debug' => true,
	'env'   => 'production',
	'providers' => [
		'\Illuminate\Filesystem\FilesystemServiceProvider',
		'\Illuminate\Events\EventServiceProvider',
		'\CodexShaper\Routing\RoutingServiceProvider',
		'Illuminate\View\ViewServiceProvider',
	]
];