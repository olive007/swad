<?php

namespace Swad\Parser;

use Swad\Exception\ParserException;

use Swad\Lexer\Token\AbstractToken;

class TokenParsed extends AbstractToken {


	// Attribute
	private $rule;
	private $result;


	// Constructor
	function __construct(Rule $rule, $result) {

		// Initialize attribute
		$this->rule = $rule;
		$this->result = $result;
	}


	// Getter
	public function getValue() {
		return $this->result;
	}

	public function getType() : string {
		return "TOKEN_PARSED";
	}

	public function getRule() : Rule {
		return $this->rule;
	}

	public function isParsed() : bool {
		return TRUE;
	}


	// Method
	public function matchComponent(string $ruleComponent) : bool {

		if ($ruleComponent == $this->rule->getName()) {
			return TRUE;
		}

		return FALSE;
	}



}