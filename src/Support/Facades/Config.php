<?php

namespace Codexshaper_Oauth_Server\Support\Facades;

/**
 * Configuration file.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Support/Facades
 */

/**
 * Configuration file.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Support/Facades
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Config {

	/**
	 * The config array.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $config
	 */
	protected $config = array();

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @param   array $options The default options.
	 *
	 * @return  void
	 */
	public function __construct( $options = array() ) {
		$dir = __DIR__ . '/../../../../../../';

		if ( ! empty( $options ) && isset( $options['paths']['root'] ) ) {
			$dir = rtrim( $options['paths']['root'], '/' ) . '/';
		}

		foreach ( glob( $dir . 'config/*.php' ) as $file ) {
			$index                  = pathinfo( $file )['filename'];
			$this->config[ $index ] = require_once $file;
		}
	}

	/**
	 * Get the config value by key.
	 *
	 * @since    1.0.0
	 * @param   string $config The config keys.
	 * @param   string $default The default value.
	 *
	 * @return  mixed
	 */
	public function get( $config, $default = null ) {
		$keys     = explode( '.', $config );
		$filename = array_shift( $keys );
		$data     = $this->config[ $filename ];

		foreach ( $keys as $key ) {
			if ( is_array( $data ) && array_key_exists( $key, $data ) ) {
				$data = $data[ $key ];
			} else {
				$data = null;
			}
		}

		if ( ! $data ) {
			$data = $default;
		}

		return $data;
	}
}
