<?php

namespace Modeler\Parser\Ui\Node;

use Modeler\Parser;

abstract class LinearLayout extends AbstractContainer {

	
	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

		if ($this->getAttribute("Weight") == null) {

			foreach (Parser::$screenSuffix as $screenSize => $screenSuffix) {

				$weight = 0;
				
				$side = "Height";
				$margin1 = "MarginTop";
				$margin2 = "MarginBottom";

				if ($this->getAttribute("Orientation")->getResponsiveValue($screenSuffix) == "horizontal") {
					$side = "Width";
					$margin1 = "MarginLeft";
					$margin2 = "MarginRight";					
				}

				for ($i = 0; $i < $this->getNbNode(); $i++) {

					$tmp = $this->getNode($i)->getAttribute($side)->getResponsiveValue($screenSuffix);
					if ($tmp == "auto") {
						$tmp = 1;
					}
					else if ($tmp == "max") {
						$this->getNode($i)->abortRender("max found in orientation");
					}
					$weight += $tmp;

					$tmp = $this->getNode($i)->getAttribute($margin1);
					$weight += isset($tmp) ? $tmp->getResponsiveValue($screenSuffix) : 0;

					$tmp = $this->getNode($i)->getAttribute($margin2);
					$weight += isset($tmp) ? $tmp->getResponsiveValue($screenSuffix) : 0;
				}

				$className = AbstractNode::$namespace."\\Attribute\\Weight";

				new $className($weight, $this, $screenSize);

			}

		}

		
	}


	// Getter	
	public function getType() : string {
		return "LinearLayout";
	}


	// Method
	public function mandatoryAttribute() {
		if (!$this->attributePresent("orientation")) {
			$this->throwMandatoryExecption("orientation");
		}
	}

}