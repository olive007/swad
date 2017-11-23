<?php

namespace Modeler\Parser\Ui\Node;

abstract class RelativeLayout extends AbstractContainer {

	
	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);
		
	}


	// Getter	
	public function getType() : string {
		return "RelativeLayout";
	}


	// Method
	public function mandatoryAttribute() {
		if (!$this->attributePresent("orientation")) {
			$this->throwMandatoryExecption("orientation");
		}
	}

}