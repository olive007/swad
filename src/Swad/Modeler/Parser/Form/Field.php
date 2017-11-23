<?php

namespace Modeler\Parser\Form;

use Pimple\Container;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Silex\Application;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\EntityManager;

use Modeler\Locale;

class Field extends AbstractField {


	// Attribute
	private $pattern;
	private $required;
	private $entityClassName;
	private $value;
	private $defaultValue;
	private $searchCondition;
	private $annotationReader;
	private static $ftab = null;




	// Constructor
	public function __construct(\SimpleXMLElement $xml, Form $form) {

		// Call AbstractField constructor
		parent::__construct($xml, $form);

		// Initialize attributes
		$this->pattern == "";
		$this->required = false;
		$this->value = NULL;
		$this->defaultValue = NULL;
		$this->searchCondition = false;

		// Send error if no id defined
		if ($this->id == "") {
			throw new Exception("Error Processing Request", 1);
		}

		// Get the class of the entity of the form
		$clazz = $this->getForm()->getEntity()->getClass();

		// Set the value
		$this->value = $xml->__toString();

		// Split id to find composite id
		$ids = preg_split("/\./", $this->id);

		// Get the annotations of the right fields
		$annotations = $this->getAnnotations($ids, $clazz->getProperties());

		foreach ($annotations as $annotation) {
			if (get_class($annotation) == "Doctrine\\ORM\\Mapping\\Column") {
				// Set the type of the form field
				$this->type = $annotation->type;
				if (!$annotation->nullable) {
					$this->required = true;
				}
			}

			else if (get_class($annotation) == "Modeler\\Annotation\\Form\\Regex") {
				
				$this->pattern = $annotation->getPattern();
				$this->patternInvalid = "";
			}

		}


	}


	// Getter
	public function getType() : string {
		return $this->type;
	}

	public function hasValue() : bool {
		return $this->value == "" ?  false : true;
	}

	public function getValue() {
		return $this->value;
	}

	public function getEntityClassName() : string {
		return $this->entityClassName;
	}

	private function getAnnotations(array $ids, array $properties) {

		// Loop all properties
		foreach ($properties as $property) {

			// Find the one with right name
			if ($property->getName() == $ids[0]) {

				// Read the annotations
				$annotations = $this->getForm()->getAnnotationReader()->getPropertyAnnotations($property);
				
				// Return if that is the last id
				if (count($ids) == 1) {
					return $annotations;
				}

				// Else Loop all annotation to find the linked entity
				foreach ($annotations as $annotation) {

					// Find relation annotations
					if (get_class($annotation) == "Doctrine\\ORM\\Mapping\\ManyToMany") {

						// Get the name of the linked entity
						$this->entityClassName = "Model\\".$annotation->targetEntity;

						// Create a object
						$entity = new $this->entityClassName;

						$reflect = new \ReflectionClass($entity);

						// Remove first element into the id array
						array_shift($ids);

						// (Recursive method) Call itself with the level of composite ids
						return $this->getAnnotations($ids, $reflect->getProperties());

					}
				}
			}
		}

		// 
		return false;
		
	}


	public function isValidatorPresent() : bool {
		return true;
	}

	public function isRequired() : bool {
		return $this->required;
	}




	// Method
	public function toDictionary(Container $app) : array {

		$res = parent::toDictionary($app);
		
		if ($this->pattern != "") {
			$res["pattern"] = $this->pattern;
		}

		return $res;
	}


	public function validate(Application $app, Request $request) {

		$content = json_decode($request->getContent());

		$message = "";

		if (gettype($content) != "string") {
			$message = $app["translator"]->trans(new Locale($request->get("locale")), "messageGeneric", "wrongContent")["translation"];
		}

		else if (!preg_match("/".$this->pattern."/", $content)) {
			$message = $app["translator"]->trans(new Locale($request->get("locale")), "messageGeneric", "patternInvalid")["translation"];
		}

		return $message;
	}


	public function createObject() {
		return new $this->entityClassName;
	}



}