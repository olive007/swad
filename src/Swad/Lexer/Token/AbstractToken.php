<?php

namespace Swad\Lexer\Token;

abstract class AbstractToken {


	// Attribute
	private $matches;


	// Constructor
	public function __construct(array $matches) {
		$this->matches = $matches;
	}


	// Getter
	public function getLength() {
		return strlen($this->matches[0]);
	}

	public function getValue() {
		return $this->matches[0];
	}

	public abstract function getType();


	// Method
	public function match(string $subject) : bool {

		if (strtoupper($subject) == $this->getType()) {
			return TRUE;
		}

		return FALSE;
	}

}