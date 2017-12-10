<?php

namespace Swad\Lexer\Token\Annotation;

use Swad\Lexer\Token\AbstractToken;

class Name extends AbstractToken {


	// Getter
	public function getType() : string {
		return "NAME";
	}

}