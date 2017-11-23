<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class Weight extends Parser\AbstractResponsiveAttribute {

	// Method
	public function generateByScreen(string $screenSuffix) {

		$value = intval($this->getResponsiveValue($screenSuffix));

		$this->node->addHtmlAttribute(Html::$attribute["LinearLayoutWeight"]."-$screenSuffix", $value);

	}


	// Getter
	public function getType() : string {
		return "Weight";
	}

}