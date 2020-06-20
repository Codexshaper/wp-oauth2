<?php

use CodexShaper\OAuth2\Server\Manager;
use Illuminate\Filesystem\Filesystem;

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    WPB_Framework
 * @subpackage WPB_Framework/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WPB_Framework
 * @subpackage WPB_Framework/includes
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class WPB_Framework_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$filesystem = new Filesystem;
		$path = __DIR__.'/../../../../';
		$htaccess = $filesystem->get($path . '.htaccess');

        if (false === strpos($htaccess, 'SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1')) {
            $filesystem->append(
                $path . '.htaccess',
                "\n\n" . 'SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1' . "\n"
            );
        }
        
		Manager::migrate();
	}

}
