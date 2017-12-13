<?php

namespace Swad\Lexer\Token;

class Token extends AbstractToken {


	// Attributes
	private $type;


	// Constructor
	public function __construct(array $matches, string $type) {

		// Call constructor form parent class
		parent::__construct($matches);

		// Initialize attributes
		$this->type = $type;
	}


	// Getter
	public function getValue() {
		return $this->matches[0];
	}

	public function getType() : string {
		return $this->type;
	}


	// Method
	public function matchComponent(string $ruleComponent) : bool {

		if ($ruleComponent == $this->type) {
			return TRUE;
		}

		return FALSE;
	}

}