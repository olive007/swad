<?php

namespace Modeler\Annotation\Form;

/**
 @Annotation
 @Target({"PROPERTY"})
 */
class Field {


	// Attribute
	/** @var string */
	private $type;
	/** @var boolean */
	private $require;

	function __construct(array $value) {
		$this->type = $value["value"];
		$this->require = isset($value["require"]) ? $value["require"] : false;
	}

	public function action(string $locale) {
		return ["type" => $this->type, "require" => $this->require];
	}

}
