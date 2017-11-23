<?php

namespace Modeler\Parser\Ui\Node;

use Modeler\Color;

abstract class Image extends AbstractNode {


	// Attribute
	private $encoding;
	private $resourceId;
	private $color;


	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

		$this->color = null;

		$tmp = $xmlNode->attributes()["Color"];

		if (isset($tmp)) {
			$this->color = Color::get($tmp."");
		}
		
	}


	// Getter	
	public function getType() : string {
		return "Image";
	}

	public function getResourceId() : string {
		return $this->resourceId;
	}

	public function getEncoding() : string {
		return $this->encoding;
	}

	public function getColor() : ?Color {
		return $this->color;
	}



	// Method
	protected function initFunctionTab() {

		parent::initFunctionTab();

		// function tab		
		$this->personnalAttribute["Color"] =	function($n, $v) {
			$this->color = $v."";

			return false;
		};
		$this->personnalAttribute["Encoding"] =	function($n, $v) {
			$this->encoding = $v."";

			return false;
		};
		$this->personnalAttribute["Id"] =		function($n, $v) {
			$this->resourceId = $v."";

			return false;
		};

	}


}