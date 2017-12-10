<?php

namespace Swad\Lexer\Token\Annotation;

use Swad\Lexer\Token\AbstractToken;

class Str extends AbstractToken {


	// Getter
	public function getType() : string {
		return "STR";
	}

}