<?php

namespace Modeler\Generator\Html\Node;

use Modeler\Parser\Ui\Node as Parser;

use Modeler\Locale;

class Text extends Parser\Text {

	use HtmlCommon;

	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, Parser\AbstractContainer $container) {

		$this->initHtmlCommon();

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

	}

	// Method
	public function generate(array $variables) : string {

		$res = "<p ".$this->htmlAttributeAsString().">";

		$res .= nl2br($this->getText(new Locale($variables["locale"])));

		$res .= "</p>";

		return $res;
	}

}