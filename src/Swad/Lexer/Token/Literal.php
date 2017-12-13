<?php

namespace Swad\Lexer\Token;

class Literal extends AbstractToken {


	// Getter
	public function getValue() {
		return $this->matches[0];
	}

	public function getType() : string {
		return "LITERAL";
	}


	// Method
	public function matchComponent(string $subject) : bool {

		if ($subject == $this->getValue()) {
			return TRUE;
		}

		return FALSE;
	}

	
}