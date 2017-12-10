<?php 

namespace Swad\Parser;

abstract class AbstractParser {

	// Class variable
	static private $rules;
	static private $components;


	// Initialization
	static public function init() {
		$rules = [];
	}


	// Class function
	static protected function parse($tokens, $config) {

		return [];

	}

}