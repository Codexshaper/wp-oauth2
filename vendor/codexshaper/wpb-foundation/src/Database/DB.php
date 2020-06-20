<?php

namespace CodexShaper\WP\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB extends Capsule
{
    protected static $instance = false;

    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function __construct()
    {
        parent::__construct();

        global $wpdb;

        $this->addConnection([

            'driver' 		    => 'mysql',
            'host' 			     => $wpdb->dbhost,
            'database' 		  => $wpdb->dbname,
            'username' 		  => $wpdb->dbuser,
            'password' 		  => $wpdb->dbpassword,
            'prefix'   		  => $wpdb->prefix,
            'charset'   		 => $wpdb->charset,
            'collation'   	=> $wpdb->collate,
        ]);

        //Make this Capsule instance available globally.
        $this->setAsGlobal();

        // Setup the Eloquent ORM.
        $this->bootEloquent();
    }
}
