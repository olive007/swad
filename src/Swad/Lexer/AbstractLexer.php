<?php

namespace Swad\Lexer;

use Swad\Exception\LexerException;

abstract class AbstractLexer {


	// Attribute
	static protected $tokens;
	static protected $literals;
	static protected $ns;


	// Constructor
	static protected function init() {

		foreach (self::$tokens as $regex => $clazz) {
			self::$tokens[$regex] = self::$ns."\\".$clazz;
		}


		foreach (str_split(self::$literals) as $literal) {
			self::$tokens["/^".preg_quote($literal)."/"] = "Swad\\Lexer\\Token\\Literal";
		}
	}


	// Method
	static public function lex($input) {

		$tokens = [];

		$input = preg_replace("/^\s*/", "", $input);
		while (0 < strlen($input)) {
			$token = self::tokenize($input);
			$input = substr($input, $token->getLength());
			$input = preg_replace("/^\s*/", "", $input);
			array_push($tokens, $token);
		}

		return $tokens;
	}

	static private function tokenize($input) {

		foreach (self::$tokens as $regex => $clazz) {

			if (!preg_match($regex, $input, $matches)) {
				continue;
			}
			return new $clazz($matches);
		}
		throw new LexerException("TokenNotFound", 1);
	}


}