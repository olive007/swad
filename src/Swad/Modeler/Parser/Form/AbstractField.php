<?php

namespace Modeler\Parser\Form;

use Pimple\Container;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManager;

use Silex\Application;

use Modeler\Exception\TranslationException;
use Modeler\Locale;

abstract class AbstractField {

	
	// Attribute
	private $xmlNode;
	private $form;
	protected $id;


	// Constructor
	protected function __construct(\SimpleXMLElement $xml, Form $form) {

		// Link the attribute
		$this->xmlNode = $xml;
		$this->form = &$form;

		// Set the id (Mandatory most of the times)
		$this->id = $xml->attributes()["id"]."";

	}


	// Getter
	abstract public function getType() : string;

	abstract public function hasValue() : bool;

	abstract public function getValue();

	abstract public function isValidatorPresent() : bool;

	abstract public function isRequired() : bool;

	public function getId() : string {
		return $this->id;
	}

	public function getForm() : Form {
		return $this->form;
	}

	public function getLabel(Container $app) : string {

		// Get the current request
		$request = $app['request_stack']->getCurrentRequest();

		// Get locale paramater form the request
		$locale = new Locale($request->get("locale"));

		// Translate the label
		$tmp = $app["translator"]->trans($locale, "Forms/".$this->form->getId(), $this->id);

		// Send error if no translation found
		if ($tmp["country"] != $locale->getCountry() || $tmp["language"] != $locale->getLanguage()) {
			throw new TranslationException($this->xmlNode, $this->form->getId(), $this->id);
		}

		// Return the label translated
		return $tmp["translation"]['label'];
	}


	// Method
	public function toDictionary(Container $app) : array {
		$res = [];

		$res["id"] = $this->getId();
		$res["label"] = $this->getLabel($app);
		if ($this->isValidatorPresent()) {
			$res["validator"] = true;
		}
		$res["type"] = $this->getType();
		if ($this->isRequired()) {
			$res["required"] = true;
		}

		return $res;
	}

	abstract public function validate(Application $app, Request $request);

}
