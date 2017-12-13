<?php

namespace Swad\Lexer\Token\Annotation;

use Swad\Lexer\Token\Token;

class Name extends Token {


	// Constructor
	public function __construct(array $matches) {

		// Call constructor form parent class
		parent::__construct($matches, "NAME");
	}


	// Getter
	public function getValue() {
		return substr($this->matches[0], 1);
	}

}