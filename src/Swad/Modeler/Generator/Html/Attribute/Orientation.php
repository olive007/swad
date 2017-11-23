<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as ParserNode;

use Modeler\Parser;

class Orientation extends ParserNode\AbstractResponsiveAttribute {

	// Method
	public function generateByScreen(string $screenSuffix) {
		
		$this->node->addHtmlAttribute(
			Html::$attribute["LinearLayoutOrientation"]."-$screenSuffix",
			Parser::$value[$this->getResponsiveValue($screenSuffix).""]
		);

	}


	// Getter
	public function getType() : string {
		return "Orientation";
	}

}