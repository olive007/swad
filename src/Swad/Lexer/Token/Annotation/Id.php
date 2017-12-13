<?php

namespace Swad\Lexer\Token\Annotation;

use Swad\Lexer\Token\Token;

class Id extends Token {


	// Constructor
	public function __construct(array $matches) {

		// Call constructor form parent class
		parent::__construct($matches, "ID");
	}


	// Getter
	public function getValue() {
		return $this->matches[0];
	}

}