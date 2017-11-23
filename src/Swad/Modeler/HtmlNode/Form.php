<?php

namespace Modeler\HtmlNode;

class Form extends AbstractNode {


	// Attributes
	private $link;



	// Constructor
	public function __construct(\SimpleXMLElement $xml, string $xmlFileName, callable $attrInherited, AbstractContainer $container = null) {

		parent::__construct($xml, $xmlFileName, $attrInherited, $container);

		$link = $xml->attributes()["link"];

		if (isset($link)) {
			$this->link = $link->__toString();			
		}


	}



	// Getter
	public function getType() : string {
		return "Form";
	}



	// Method
	public function renderHtml(\Pimple\Container $container) {


		$res = '<form '.$this->generateAttributes().' action="#" link="'.$this->link.'">';

		$res .="</form>";

		return $res;
	}


}
