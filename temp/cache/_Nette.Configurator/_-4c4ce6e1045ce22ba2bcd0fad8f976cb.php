<?php //netteCache[01]000208a:2:{s:4:"time";s:21:"0.50915200 1320161971";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:38:"E:\workplace\uspck-new\app/config.neon";i:2;i:1320161968;}}}?><?php
// source file E:\workplace\uspck-new\app/config.neon

$container->addService('robotLoader', function($container) {
	return call_user_func(
		array ( 0 => 'Nette\\Configurator', 1 => 'createServicerobotLoader', ),
		$container
	);
}, array ( 0 => 'run', ));

$container->addService('database', function($container) {
	$class = 'Nette\\Database\\Connection'; $service = new $class('mysql:host=elianos.buk.cvut.cz;dbname=uspck', 'root', '');
	return $service;
}, array ( 0 => 'run', ));

$container->addService('authenticator', function($container) {
	$class = 'MyAuthenticator'; $service = new $class($container->getService('database'));
	return $service;
}, NULL);

date_default_timezone_set('Europe/Prague');

Nette\Caching\Storages\FileStorage::$useDirectories = true;

foreach ($container->getServiceNamesByTag("run") as $name => $foo) { $container->getService($name); }
