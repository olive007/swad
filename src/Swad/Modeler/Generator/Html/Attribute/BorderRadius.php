<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class BorderRadius extends Parser\AbstractResponsiveAttribute {

	// Method
	public function generateByScreen(string $screenSuffix) {

		$value = $this->getResponsiveValue($screenSuffix);

		$this->node->addHtmlAttribute(Html::$attribute["ElementBorderRadius"]."-$screenSuffix", $value);

	}

	// Getter
	public function getType() : string {
		return "BorderRadius";
	}


}