<?php

namespace Modeler\Generator\Html;

use Modeler\Parser\Ui\Node as Parser;

use Modeler\Locale;

class Text extends Parser\Text {

	// Method
	public function render(array $variables) : string {

		$res = "<p>".$this->translateText(new Locale($variables["locale"]), $this->getAttribute("Id")->getValue())."</p>";

		return $res;
	}

}