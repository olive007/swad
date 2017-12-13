<?php

namespace Swad\Lexer\Token\Annotation;

use Swad\Lexer\Token\Token;

class Integer extends Token {


	// Constructor
	public function __construct(array $matches) {

		// Call constructor form parent class
		parent::__construct($matches, "INTEGER");
	}


	// Getter
	public function getValue() {
		return intval($this->matches[0]);
	}

}