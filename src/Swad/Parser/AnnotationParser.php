<?php

namespace Swad\Parser;

use Swad\Lexer\AnnotationLexer;

class AnnotationParser extends AbstractParser {



	// Monostate intialization
	static public function init() {
		AnnotationLexer::init();
		parent::init();
	}


	// Grammar
	/**
	 * declarations : declaration
	 *				| declaration declarations
	 */
	static protected function declarationsRule() {
		return [
			function($tokens, $config) {
				print_r("toto");
				return [$tokens[0]->getValue()];
			},
			function($tokens, $config) {
				print_r("toto r");
				print_r($tokens);
				return array_merge([$tokens[0]->getValue()], $tokens[1]->getValue());
			}
		];
	}

	/**
	 * declaration : NAME
	 *			   | NAME ( )
	 *			   | NAME ( value )
	 *			   | NAME ( variable )
	 */
	static protected function declarationRule() {
		return [
			function($tokens, $config) {

				print_r("Tata : ");
				$clazz = "Swad\\Controller\\Annotation\\".$tokens[0]->getValue();
				return new $clazz();
			},
			function($tokens, $config) {

				print_r("Tata : ()");
				$clazz = "Swad\\Controller\\Annotation\\".$tokens[0]->getValue();
				return new $clazz();
			},
			function($tokens, $config) {
				
				print_r("Tata : ( value )");
				$clazz = "Swad\\Controller\\Annotation\\".$tokens[0]->getValue();
				return new $clazz($tokens[2]->getValue());
			},
			function($tokens, $config) {

				print_r("Tata : ( variable )");
				$clazz = "Swad\\Controller\\Annotation\\".$tokens[0]->getValue();
				return new $clazz($tokens[2]->getValue());
			}
		];
	}


	/**
	 * value : INTEGER
	 *		 | STR
	 *		 | FLOAT
	 */
	static protected function valueRule() {
		return [
			function($tokens, $config) {
				return $tokens[0]->getValue();
			},
			function($tokens, $config) {
				return $tokens[0]->getValue();
			},
			function($tokens, $config) {
				return $tokens[0]->getValue();
			}
		];
	}


	/**
	 * variable : ID = value
	 */
	static protected function variableRule() {
		return [
			function($tokens, $config) {
				return $tokens[2]->getValue();
			}
		];
	}


	// Class Method
	static public function parse($obj, $config) {

		$docComment = $obj->getDocComment();

		$docComment = preg_replace('/^[\/\* \t]+/m', '', $docComment);

		$tokens = AnnotationLexer::lex($docComment);

		return parent::parse($tokens, $config);

	}



}