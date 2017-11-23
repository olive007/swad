<?php

namespace Modeler\Generator\Html\Node;

use Modeler\Parser\Ui\Node as Parser;

class Image extends Parser\Image {

	use HtmlCommon;


	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, Parser\AbstractContainer $container) {

		$this->initHtmlCommon();

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

	}


	// Method
	public function generate(array $variables) : string {

		$path = "/".$this->getEncoding()."/".$this->getResourceId();

		if ($this->getColor() != null) {
			$path .= "/".$this->getColor()->getId();
		}

		$this->addHtmlAttribute("src", $path);

		$res = "<img ".$this->htmlAttributeAsString()."/>";

		return $res;
	}

}