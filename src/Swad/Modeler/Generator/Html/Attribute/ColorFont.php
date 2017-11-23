<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class ColorFont extends Parser\Color {

	// Method
	public function generate() {

		$this->node->addHtmlClass(Html::$class["colorFontPrefix"].ucfirst($this->getColor()->getId()));

	}

	// Getter
	public function getType() : string {
		return "ColorFont";
	}


}