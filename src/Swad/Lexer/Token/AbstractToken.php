<?php

namespace Swad\Lexer\Token;

abstract class AbstractToken {


	// Attribute
	protected $matches;


	// Constructor
	public function __construct(array $matches) {

		// Initialize attributes
		$this->matches	= $matches;
	}


	// Getter
	public abstract function getValue();

	public abstract function getType() : string;

	public function getLength() : int {
		return strlen($this->matches[0]);
	}

	public function isParsed() : bool {
		return FALSE;
	}


	// Method
	public abstract function matchComponent(string $subject) : bool;

}