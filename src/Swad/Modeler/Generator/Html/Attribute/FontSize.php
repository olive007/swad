<?php

namespace Modeler\Generator\Html\Attribute;

use Modeler\Generator\Html;

use Modeler\Parser\Ui\Attribute as Parser;

class FontSize extends Parser\AbstractResponsiveAttribute {

	// Method
	public function generateByScreen(string $screenSuffix) {
		
		$value = $this->getResponsiveValue($screenSuffix);

		if ($value == "filled") {
			$this->node->addHtmlClass(Html::$class["textFilled"]."-$screenSuffix");
		}
		else {
			$this->node->addHtmlAttribute(Html::$attribute["TextFontSize"]."-$screenSuffix", $value);
		}

	}


	// Getter
	public function getType() : string {
		return "FontSize";
	}

}