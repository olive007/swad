<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class Font extends Parser\AbstractAttribute {

	// Method
	public function generate() {
		$this->node->addHtmlClass(Html::$class["fontPrefix"].ucfirst($this->getValue()));
	}


	// Getter
	public function getType() : string {
		return "Font";
	}

}