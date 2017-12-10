<?php

namespace Swad\Parser;

use Swad\Lexer\AnnotationLexer;

class AnnotationParser extends AbstractParser {



	// Monostate intialization
	static public function init() {
		AnnotationLexer::init();
	}


	// Class Method
	static public function parse($obj, $config) {

		$docComment = $obj->getDocComment();

		$docComment = preg_replace("/^\s\*/m", "", $docComment);

		print($docComment);

		$tokens = AnnotationLexer::lex($docComment);


		return parent::parse($tokens, $config);

	}



}