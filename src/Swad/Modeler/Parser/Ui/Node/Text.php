<?php

namespace Modeler\Parser\Ui\Node;

use Modeler\Locale;

abstract class Text extends AbstractNode {


	// Attribute
	private $resourceId;


	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		// Initialize attribute
		$this->resourceId = null;

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

	}


	// Getter	
	public function getType() : string {
		return "Text";
	}

	public function getText(Locale $locale) : string {

		if ($this->resourceId != null) {
			return $this->translateText($locale, $this->resourceId);
		}

		return trim($this->getXmlNode()."");
	}


	// Method
	protected function initFunctionTab() {

		parent::initFunctionTab();

		$this->personnalAttribute["Id"] = function($n, $v) {

			$this->resourceId = $v."";

			return false;
		};

	}



}