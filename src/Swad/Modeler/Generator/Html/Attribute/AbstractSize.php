<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Parser\Ui\Attribute as ParserNode;

use Modeler\Parser;

abstract class AbstractSize extends ParserNode\AbstractResponsiveAttribute {

	// Method
	protected function computeValue(string $screenSuffix) {

		$value = 0.;

		if ($this->getResponsiveValue($screenSuffix) == "auto") {
			$value = Parser::$value["auto"];
		}
		else if ($this->getResponsiveValue($screenSuffix) == "max") {
			$value = Parser::$value["max"];
		}
		else {
			if ($this->node->getContainer()->getType() == "LinearLayout") {
				$value = floatval($this->getResponsiveValue($screenSuffix)."");
			}
			else {
				$value = $this->getResponsiveValue($screenSuffix)."";
			}
		}

		return $value;

	}


}