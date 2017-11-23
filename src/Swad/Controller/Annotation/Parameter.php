<?php

namespace Api\Annotation;

use Silex\ControllerCollection;

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;


/**
 * @Annotation
 * @Target({"ANNOTATION"})
 */
class Parameter {

	private $name;
	private $regex;
	private $default;

	function __construct(array $values) {
		$this->name = $values['value'];
		$this->regex = $values['regex'];
		$this->default = isset($values['default']) ? $values['default'] : NULL;
	}


	// Getter
	public function getName() {
		return $this->name;
	}

	public function getRegex() {
		return $this->regex;
	}

	public function getDefault() {
		return $this->default;
	}

	public function isRequired() {
		return $this->default === NULL ? true : false;
	}


}
