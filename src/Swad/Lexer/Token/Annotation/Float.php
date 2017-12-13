<?php

namespace Swad\Lexer\Token\Annotation;

use Swad\Lexer\Token\Token;

class Float extends Token {


	// Constructor
	public function __construct(array $matches) {

		// Call constructor form parent class
		parent::__construct($matches, "FLOAT");
	}


	// Getter
	public function getValue() {
		return floatval($this->matches[0]);
	}

}