<?php

namespace Swad;

use Swad\AbstractApplication;

class Console {

	// Attribute
	private $app;


	// Constructor
	public function __construct(AbstractApplication $app, string $testFolder) {

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
