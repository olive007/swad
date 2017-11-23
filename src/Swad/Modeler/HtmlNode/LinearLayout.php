<?php

namespace Modeler\HtmlNode;

use Modeler\Exception\WrongAttributeException;
use Modeler\Exception\MandatoryAttributeException;

class LinearLayout extends AbstractContainer {

	// Attribute
	protected $orientation;
	protected $overflow;
	protected $weight;


	// Constructor
	public function __construct(\SimpleXMLElement $xml, string $xmlFileName, callable $attrInherited, AbstractContainer $container = null) {

		parent::__construct($xml, $xmlFileName, $attrInherited, function($xml, $xmlFileName, AbstractNode $obj) {

			// Initialise variable
			$obj->marginTop = $obj->marginBottom = $obj->marginLeft = $obj->marginRight = [
				self::$jsAttr["smallScreen"] => 0,
				self::$jsAttr["mediumScreen"] => 0,
				self::$jsAttr["largeScreen"] => 0
			];

			// Set the width
			if ($obj->setModelerAttr($xml, "width", function($v) {
				if ($v == "max") {
					return self::$jsAttr["Size-max"];
				}
				else if ($v == "auto") {
					return self::$jsAttr["Size-auto"];
				}
				return intval($v);
			})) {
				$obj->addModelerAttr("Layout-width", $obj->width);
			}
			else {
				throw new MandatoryAttributeException($xml, $xmlFileName, "width");
			}

			// Set the height
			if ($obj->setModelerAttr($xml, "height", function($v) {
				if ($v == "max") {
					return self::$jsAttr["Size-max"];
				}
				else if ($v == "auto") {
					return self::$jsAttr["Size-auto"];
				}
				return intval($v);
			})) {
				$obj->addModelerAttr("Layout-height", $obj->height);
			}
			else {
				throw new MandatoryAttributeException($xml, $xmlFileName, "height");
			}


			if ($obj->setModelerAttr($xml, "marginTop", function($v) { return intval($v); })) {
				$obj->addModelerAttr("LinearLayout-marginTop", $obj->marginTop);
			}

			if ($obj->setModelerAttr($xml, "marginBottom", function($v) { return intval($v); })) {
				$obj->addModelerAttr("LinearLayout-marginBottom", $obj->marginBottom);
			}

			if ($obj->setModelerAttr($xml, "marginLeft", function($v) { return intval($v); })) {
				$obj->addModelerAttr("LinearLayout-marginLeft", $obj->marginLeft);
			}

			if ($obj->setModelerAttr($xml, "marginRight", function($v) { return intval($v); })) {
				$obj->addModelerAttr("LinearLayout-marginRight", $obj->marginRight);
			}


		}, $container);


		// Initialize variable
		$this->weight[self::$jsAttr["smallScreen"]] = -1;
		$this->weight[self::$jsAttr["mediumScreen"]] = -1;
		$this->weight[self::$jsAttr["largeScreen"]] = -1;

		$this->orientation = [];
		$this->overflow = [];


		// Set the weight
		$this->setModelerAttr($xml, "weight", function($v) { return intval($v); });

		$tmp = $this->setModelerAttr($xml, "orientation");
		if ($tmp[self::$jsAttr["smallScreen"]] && $tmp[self::$jsAttr["mediumScreen"]] && $tmp[self::$jsAttr["largeScreen"]]) {
			$this->addModelerAttr("LinearLayout-orientation", $this->orientation, function ($v) { return self::$jsValue[$v]; });
		}
		else {
			throw new MandatoryAttributeException($xml, $xmlFileName, "orientation");
		}


		if ($this->setModelerAttr($xml, "overflow")) {
			foreach ($this->overflow as $prefix => $ov) {
				if ($ov == "horizontal") {
					$this->addStyleClass("overflowHorizontal", $prefix);
				}
				else if ($ov == "vertical") {
					$this->addStyleClass("overflowVertical", $prefix);
				}
				else if ($ov == "both") {
					$this->addStyleClass("overflowBoth", $prefix);
				}
				else {
					throw new WrongAttributeException($xml, $xmlFileName, "overflow");
				}
			}
		}

		foreach ([self::$jsAttr["smallScreen"], self::$jsAttr["mediumScreen"], self::$jsAttr["largeScreen"]] as $prefix) {
			for ($i = 0; $i < $this->getNbNode(); $i++) {
				if ($this->orientation[$prefix] == "horizontal") {
					if ($this->getNode($i)->getWidth($prefix) == self::$jsAttr["Size-max"]) {
						$this->abortRender("Wrong max");
					}
				}
				else if ($this->orientation[$prefix] == "vertical") {
					if ($this->getNode($i)->getHeight($prefix) == self::$jsAttr["Size-max"]) {
						$this->abortRender("Wrong max");
					}
				}
			}
		}

		$this->addStyleClass("layoutLinear");
		$this->addScriptClass("layoutLinear");

	}



	// Getter
	public function getType() : string {
		return "LinearLayout";
	}

	public function getWeight(string $prefix) : int {

		if ($this->weight[$prefix] != -1) {
			return $this->weight[$prefix];
		}

		$res = 0;
		if ($this->orientation[$prefix] == "horizontal") {
			for ($i = 0; $i < $this->getNbNode(); $i++) {
				$tmp = $this->getNode($i)->getWidth($prefix);
				if ($tmp == self::$jsAttr["Size-max"]) {
					$this->getNode($i)->abortRender("max found in orientation horizontal");
				}
				$res += $tmp;
				$res += $this->getNode($i)->marginRight[$prefix];
				$res += $this->getNode($i)->marginLeft[$prefix];
			}
		}
		else if ($this->orientation[$prefix] == "vertical") {
			for ($i = 0; $i < $this->getNbNode(); $i++) {
				$tmp = $this->getNode($i)->getHeight($prefix);
				if ($tmp == self::$jsAttr["Size-max"]) {
					$this->getNode($i)->abortRender("max found in orientation vertical");
				}
				$res += $tmp;
				$res += $this->getNode($i)->marginTop[$prefix];
				$res += $this->getNode($i)->marginBottom[$prefix];
			}
		}
		$this->weight[$prefix] = $res;
		return $res;
	}



	// Method
	protected function generateAttributes() {

		$this->getWeight(self::$jsAttr["smallScreen"]);
		$this->getWeight(self::$jsAttr["mediumScreen"]);
		$this->getWeight(self::$jsAttr["largeScreen"]);
		$this->addModelerAttr("LinearLayout-weight", $this->weight);

		return parent::generateAttributes();
	}

	public function renderHtml(\Pimple\Container $container) {
		$res = '<div '.$this->generateAttributes().">";

		for ($i = 0; $i < $this->getNbNode(); $i++) {
			$res .= $this->getNode($i)->renderHtml($container);
		}

		$res .= "</div>";
		return $res;
	}


}
