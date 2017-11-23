<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class ColorBorder extends Parser\Color {

	// Method
	public function generate() {

		$this->node->addHtmlClass(Html::$class["colorBorderPrefix"].ucfirst($this->getColor()->getId()));

	}


	// Getter
	public function getType() : string {
		return "ColorBorder";
	}


}