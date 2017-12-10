<?php

namespace Swad\Lexer\Token;

class Literal extends AbstractToken {

	// Getter
	public function getType() : string {
		return "LITERAL";
	}


	// Method
	public function matchComponent(string $subject) : bool {

		if (strcmp($subject, $this->getValue())) {
			return TRUE;
		}

		return FALSE;
	}

	
}