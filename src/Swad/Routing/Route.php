<?php

namespace Swad\Routing;

class Route {

	// Attribute
	private $prefix;
	private $pattern;
	private $action;


	function __construct(string $pattern, callable $action, $prefix) {
	
		// Initialize attributes
		$this->pattern = $pattern;
		$this->action  = $action;
	}

}