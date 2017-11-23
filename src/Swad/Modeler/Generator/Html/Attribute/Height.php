<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

class Height extends AbstractSize {

	// Method
	public function generateByScreen(string $screenSuffix) {

		$value = $this->computeValue($screenSuffix);

		$this->node->addHtmlAttribute(Html::$attribute["LayoutHeight"]."-$screenSuffix", $value);

	}

	// Getter
	public function getType() : string {
		return "Height";
	}


}