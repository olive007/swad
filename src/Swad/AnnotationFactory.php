<?php 

namespace Swad;

use Swad\Parser\AnnotationParser;

abstract class AnnotationFactory {


	// Class Variable
	static private $config;


	// Initiliation
	static public function init() {

		AnnotationParser::init();
		self::$config = [];

	}


	static public function getAnnotations($obj) {

		return AnnotationParser::parse($obj, self::$config);

	}

}