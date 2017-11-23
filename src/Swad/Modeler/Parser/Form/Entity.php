<?php

namespace Modeler\Parser\Form;

class Entity {

	// Attribute
	private $name;
	private $form;
	private $annotations;


	// Constructor
	public function __construct(\SimpleXMLElement $xml, Form $form) {

		// Link the entity to the form
		$this->form = $form;

		// Set the name of the entity
		$this->name = $xml."";

		$this->annotations = $form->getAnnotationReader()->getClassAnnotations($this->getClass());

		$ftab = [];

		foreach ($this->annotations as $annotation) {
			$index = get_class($annotation);

			if (array_key_exists($index, $ftab)) {
				$ftab[$index]($this, $annotation);
			}

		}


	}


	// Getter
	public function getName() : string {
		return "Model\\".$this->name;
	}


	public function getClass() {

		// Get the name of the class
		$className = "Model\\".$this->name;

		// Construct the object
		$obj = new $className;

		// Get the reflection
		$r = new \ReflectionClass($obj);

		return $r;
	}


}
