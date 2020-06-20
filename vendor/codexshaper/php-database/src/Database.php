<?php

namespace CodexShaper\Database;

use Illuminate\Database\Capsule\Manager as CapsulManager;

class Database extends CapsulManager
{
	/**
     * Inherited.
     *
     * @var object
     */
	protected static $instance = false;

	public static function instance() {
		if(!static::$instance) {
			static::$instance = new self;
		}

		return static::$instance;
	}

	public function __construct($options = []) {

		parent::__construct();

		if(!empty($options)) {
			$this->addConnection($options);
		}
	}

	public function run()
	{
		//Make this Database instance available globally.
		$this->setAsGlobal();

		// Setup the Eloquent ORM.
		$this->bootEloquent();
	}
}