<?php

namespace Modeler\Parser\Form;

use Pimple\Container;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManager;

use Silex\Application;

class Submit extends AbstractField {

	// Constructor
	public function __construct(\SimpleXMLElement $xml, Form $form) {

		parent::__construct($xml, $form);

		if ($this->id == "") {
			$this->id = "submit";
		}


	}


	// Getter
	public function getType() : string {
		return "submit";
	}

	public function hasValue() : bool {
		return false;
	}

	public function isSearchCondition() : bool {
		return false;
	}

	public function getValue() {
		return "";
	}

	public function hasDefaultValue() : bool {
		return false;
	}

	public function getDefaultValue() {
		return "";
	}

	public function isValidatorPresent() : bool {
		return false;
	}

	public function isRequired() : bool {
		return false;
	}


	// Method
	public function validate(Application $app, Request $request) {
		return "";
	}

	public function inflateEntity($entity, $data, EntityManager $em) {

	}

	public function setEntityValue(&$entity, $value, EntityManager $em, &$errorFunct) {

	}


}
