<?php

class Install_Composer
{
	public function __construct()
	{
		if (! file_exists(__DIR__.'/vendor/autoload.php')) {

			require_once __DIR__.'/install/vendor/autoload.php';

			if(file_exists(__DIR__ . '/install/vendor/bin/composer')) {
				echo "composer file exists";
			}

			// Composer\Factory::getHomeDir() method 
			// needs COMPOSER_HOME environment variable set
			putenv('COMPOSER_HOME=' . __DIR__ . '/install/vendor/bin/composer');

			// call `composer install` command programmatically
			// if (file_exists(getcwd().'/composer.phar')) {
			//     $composer = '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
			// }

			$composer = 'composer';

			try {
				$process = \Symfony\Component\Process\Process::fromShellCommandline($composer.' install');
		    	$process->setEnv([
		    		'COMPOSER_HOME' => __DIR__ . '/install/vendor/bin/composer',
		    	]);
		    	$process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
		    	$process->setWorkingDirectory(__DIR__)->mustRun();
			} catch (\Exception $ex) {
				echo $ex->getMessage();
			}
		}
	}
}