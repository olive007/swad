<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class ColorInput extends Parser\Color {

	// Method
	public function generate() {

		$this->node->addHtmlClass(Html::$class["colorInputPrefix"].ucfirst($this->getColor()->getId()));

	}


	// Getter
	public function getType() : string {
		return "ColorInput";
	}


}