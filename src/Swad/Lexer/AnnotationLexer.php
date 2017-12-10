<?php

namespace Swad\Lexer;

final class AnnotationLexer extends AbstractLexer {


	// Constructor
	static public function init() {

		self::$tokens = [
			"/^@\w+/"			=> "Name",
			"/^[a-zA-Z]+\w*/"	=> "Id",
			"/^[0-9]+/"			=> "Integer",
			"/^[0-9]*\.[0-9]+/"	=> "Float",
			'/^(["\'])(.*)\1/'	=> "Str"
		];

		self::$literals = "()[]{},:";

		self::$ns = "Swad\\Lexer\\Token\\Annotation";

		parent::init();

	}

}