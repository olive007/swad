<?php

namespace Modeler\Parser\Ui\Node;

abstract class Form extends AbstractNode {


	// Attribute
	private $link;


	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);
		
	}


	// Getter	
	public function getType() : string {
		return "Form";
	}

	public function getLink() : string {
		return $this->link;
	}

	// Method
	protected function initFunctionTab() {

		parent::initFunctionTab();

		// function tab		
		$this->personnalAttribute["Link"] =	function($n, $v) {
			$this->link = $v."";

			return false;
		};

	}

}