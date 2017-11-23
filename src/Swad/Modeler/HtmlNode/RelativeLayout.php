<?php

namespace Modeler\HtmlNode;

use Modeler\Exception\WrongAttributeException;
use Modeler\Exception\MandatoryAttributeException;

class RelativeLayout extends AbstractContainer {


	// Constructor
	public function __construct(\SimpleXMLElement $xml,
		string $xmlFileName,
		callable $attrInherited,
		AbstractContainer $container = null) {

		parent::__construct($xml, $xmlFileName, $attrInherited, function(\SimpleXMLElement $xml, string $xmlFileName, AbstractNode $obj) {

			// Initialize the variable
			$obj->positionVertical = $obj->positionHorizontal = [];
			$obj->anchorTop = $obj->anchorBottom = $obj->anchorLeft = $obj->anchorLeft = [];

			// Set the width
			if ($obj->setModelerAttr($xml, "width", function($v) {
				if ($v == "auto") {
					return self::$jsAttr["Size-auto"];
				}
				return floatval($v);
			})) {
				$obj->addModelerAttr("Layout-width", $obj->width);
			}
			else {
				throw new MandatoryAttributeException($xml, $xmlFileName, "width");
			}

			// Set the height
			if ($obj->setModelerAttr($xml, "height", function($v) {
				if ($v == "auto") {
					return self::$jsAttr["Size-auto"];
				}
				return floatval($v);
			})) {
				$obj->addModelerAttr("Layout-height", $obj->height);
			}
			else {
				throw new MandatoryAttributeException($xml, $xmlFileName, "height");
			}


			// Vertical Positioning

			// Set the position
			$presentPV = $obj->setModelerAttr($xml, "positionVertical");
			// or Set one of the both anchor
			$presentAT = $obj->setModelerAttr($xml, "anchorTop", function($v) {
				return intval($v);
			});
			$presentAB = $obj->setModelerAttr($xml, "anchorBottom", function($v) {
				return intval($v);
			});

			foreach ([self::$jsAttr["smallScreen"], self::$jsAttr["mediumScreen"], self::$jsAttr["largeScreen"]] as $prefix) {
				$presentV[$prefix] = $presentPV[$prefix] || $presentAT[$prefix] || $presentAB[$prefix];
				if ($presentPV[$prefix]) {
					if (!($obj->positionVertical[$prefix] == "top" ||
						  $obj->positionVertical[$prefix] == "middle" ||
						  $obj->positionVertical[$prefix] == "bottom")) {
							throw new WrongAttributeException($xml, $xmlFileName, "positionVertical");
						}
					$obj->addStyleClass("position".ucfirst($obj->positionVertical[$prefix]), $prefix);
				}
				else if ($presentAT[$prefix]) {
					$obj->addModelerAttrOneScreen("RelativeLayout-anchorTop", $obj->anchorTop, $prefix);
				}
				else if ($presentAB[$prefix]) {
					$obj->addModelerAttrOneScreen("RelativeLayout-anchorBottom", $obj->anchorBottom, $prefix);
				}
			}

			// Test if one of the rule are present
			if (!$presentV[self::$jsAttr["smallScreen"]] &&
				!$presentV[self::$jsAttr["mediumScreen"]] &&
				!$presentV[self::$jsAttr["largeScreen"]]) {
				throw new MandatoryAttributeException($xml, $xmlFileName, "positionVertical or anchorTop or anchorBottom");
			}



			// Horizontal Positioning

			// Set the position
			$presentPH = $obj->setModelerAttr($xml, "positionHorizontal");
			// or Set one of the both anchor
			$presentAL = $obj->setModelerAttr($xml, "anchorLeft", function($v) {
				return intval($v);
			});
			$presentAR = $obj->setModelerAttr($xml, "anchorRight", function($v) {
				return intval($v);
			});

			foreach ([self::$jsAttr["smallScreen"], self::$jsAttr["mediumScreen"], self::$jsAttr["largeScreen"]] as $prefix) {
				$presentH[$prefix] = $presentPH[$prefix] || $presentAL[$prefix] || $presentAR[$prefix];
				if ($presentPH[$prefix]) {
					if (!($obj->positionHorizontal[$prefix] == "left" ||
						  $obj->positionHorizontal[$prefix] == "center" ||
						  $obj->positionHorizontal[$prefix] == "right")) {
							throw new WrongAttributeException($xml, $xmlFileName, "positionHorizontal");
						}
					$obj->addStyleClass("position".ucfirst($obj->positionHorizontal[$prefix]), $prefix);
				}
				else if ($presentAL[$prefix]) {
					$obj->addModelerAttrOneScreen("RelativeLayout-anchorLeft", $obj->anchorLeft, $prefix);
				}
				else if ($presentAR[$prefix]) {
					$obj->addModelerAttrOneScreen("RelativeLayout-anchorRight", $obj->anchorRight, $prefix);
				}
			}

			// Test if one of the rule are present
			if (!$presentH[self::$jsAttr["smallScreen"]] &&
				!$presentH[self::$jsAttr["mediumScreen"]] &&
				!$presentH[self::$jsAttr["largeScreen"]]) {
				throw new MandatoryAttributeException($xml, $xmlFileName, "positionHorizontal or anchorLeft or anchorRight");
			}

		}, $container);

		$this->addStyleClass("layoutRelative");
		$this->addScriptClass("layoutRelative");

	}



	// Getter
	public function getType() : string {
		return "RelativeLayout";
	}


	// Method
	public function renderHtml(\Pimple\Container $container) {
		$res = '<div '.$this->generateAttributes().'>';

		for ($i = 0; $i < $this->getNbNode(); $i++) {
			$res .= $this->getNode($i)->renderHtml($container);
		}

		$res .= "</div>";
		return $res;
	}


}
