<?php

return array(
	'debug'     => true,
	'env'       => 'production',
	'providers' => array(
		'\Illuminate\Filesystem\FilesystemServiceProvider',
		'\Illuminate\Events\EventServiceProvider',
		'\CodexShaper\Routing\RoutingServiceProvider',
		'Illuminate\View\ViewServiceProvider',
	),
);
