<?php

namespace Modeler\Annotation\Form;

/**
 @Annotation
 */
class Regex {

	private $pattern;

	public function __construct(array $values) {
		$this->pattern = $values["value"];
	}

	public function validate($value) {
		return true;
	}

	public function getPattern() {
		return $this->pattern;
	}

	public function getMessage(string $locale) {
		return "Regex Message";
	}

	public function action(string $locale) {
		return ["pattern" => $this->pattern, "message" => $this->getMessage($locale)];
	}

}
