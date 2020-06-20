<?php

use Illuminate\Filesystem\Filesystem;

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    WPB_Framework
 * @subpackage WPB_Framework/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WPB_Framework
 * @subpackage WPB_Framework/includes
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class WPB_Framework_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$filesystem = new Filesystem;
		$path = __DIR__.'/../../../../';
		$htaccess_contents = $filesystem->get($path.'.htaccess');
		$htaccess_contents = str_replace('SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1', '', $htaccess_contents);
		$htaccess_contents = array_filter(explode("\n", $htaccess_contents));
		$filesystem->put(
		    $path.'.htaccess',
		    implode("\n", $htaccess_contents)."\n"
		);
	}

}
