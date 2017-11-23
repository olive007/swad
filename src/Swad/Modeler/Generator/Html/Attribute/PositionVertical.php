<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class PositionVertical extends Parser\AbstractResponsiveAttribute {

	// Method
	public function generateByScreen(string $screenSuffix) {

		$this->node->addHtmlClass(Html::$class["position".ucfirst($this->getResponsiveValue($screenSuffix))]."-$screenSuffix");

	}


	// Getter
	public function getType() : string {
		return "PositionVertical";
	}

}