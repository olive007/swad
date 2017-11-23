<?php

namespace Swad;

use Swad\Application;

class Console {

	// Attribute
	private $app;


	// Constructor
	public function __construct(Application $app) {

		// Initialize attribute
		$this->app = $app;
	}


	// Method
	public function run(array $argv) : int {

		// Initialize variable
		$res = 0;

		return $res;
	}

}
