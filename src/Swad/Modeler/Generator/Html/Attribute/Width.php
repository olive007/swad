<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

class Width extends AbstractSize {

	// Method
	public function generateByScreen(string $screenSuffix) {

		$value = $this->computeValue($screenSuffix);

		$this->node->addHtmlAttribute(Html::$attribute["LayoutWidth"]."-$screenSuffix", $value);

	}

	// Getter
	public function getType() : string {
		return "Width";
	}


}