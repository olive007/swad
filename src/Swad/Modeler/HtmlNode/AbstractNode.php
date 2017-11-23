<?php

namespace Modeler\HtmlNode;

use Modeler\Color;

use Modeler\Exception\RenderException;
use Modeler\Exception\MandatoryAttributeException;
use Modeler\Exception\TranslationException;

abstract class AbstractNode {


	// Class variable
	public static $segmentDirectory;
	public static $jsAttr;
	public static $jsValue;
	public static $htmlClass;




	// Attributes
	private $container;
	private $xmlNode;
	private $xmlFileName;
	private $attributes;
	private $styleClass;
	private $scriptClass;
	private $transResource;

	private $backgroundColor;
	private $fontColor;
	private $textAlignHorizontal;
	private $textAlignVertical;
	private $linkDest;




	// Class method
	public static function createFromFile($fileName) {

		// Load the xml form the file
		$xml = simplexml_load_file($fileName);

		$name = "Modeler\\HtmlNode\\".$xml->getName();

		$res = new $name($xml, $fileName, function($xml, $xmlFileName, $obj) {});
		$res->setTransResource($fileName);

		return $res;

	}



	// Constructor
	protected function __construct(\SimpleXMLElement $xml,
		string $xmlFileName,
		callable $attrInherited,
		AbstractContainer $container = null) {


		// Link the container with its child
		$this->container = $container;
		$this->xmlNode = $xml;
		$this->xmlFileName = $xmlFileName;


		// Initialize the variable
		$this->attributes = $this->styleClass = $this->scriptClass = [];

		$this->backgroundColor = [];
		$this->fontColor = [];
		$this->textAlignHorizontal = [];
		$this->textAlignVertical = [];



		// Set the background color
		$tmp = $this->setModelerAttr($xml, "backgroundColor");
		foreach ($tmp as $prefix => $value) {
			if ($value)
				array_push($this->styleClass, self::$htmlClass["backgroundColor"].ucfirst($this->backgroundColor[$prefix]).ucfirst($prefix));
		}

		// Set the font color
		$tmp = $this->setModelerAttr($xml, "fontColor");
		foreach ($tmp as $prefix => $value) {
			if ($value)
				array_push($this->styleClass, self::$htmlClass["fontColor"].ucfirst($this->fontColor[$prefix]).ucfirst($prefix));
		}

		// Set the textAlign
		$tmp = $this->setModelerAttr($xml, "textAlignHorizontal");
		foreach ($tmp as $prefix => $value) {
			if ($value)
				$this->addStyleClass("textAlign".ucfirst($this->textAlignHorizontal[$prefix]), $prefix);
		}

		// Set the textAlign
		$tmp = $this->setModelerAttr($xml, "textAlignVertical");
		foreach ($tmp as $prefix => $value) {
			if ($value)
				$this->addScriptClass("textAlign".ucfirst($this->textAlignVertical[$prefix]), $prefix);
		}


		call_user_func($attrInherited, $xml, $xmlFileName, $this);

	}


	// Getter	
	abstract public function getType() : string;

	public function getBackgroundColor() : ?Color {
		return $this->backgroundColor;
	}

	public function getFontColor() : ?Color {
		return $this->fontColor;
	}

	public function getWidth(string $prefix) {
		return $this->width[$prefix];
	}

	public function getHeight(string $prefix) {
		return $this->height[$prefix];
	}

	public function getLinkDest() : ?string {
		return $this->linkDest;
	}

	public function getAttribute(string $key) : int {
		return $this->attribute[$key];
	}

	public function getContainer() : ?AbstractContainer {
		return $this->container;
	}

	public function getTransResource() : string {
		return ($this->transResource == null) ? $this->getContainer()->getTransResource() : $this->transResource;
	}



	// Setter
	public function setModelerAttr(\SimpleXMLElement $xml, string $name, callable $computeValue = null) : array {

		$existing[self::$jsAttr["smallScreen"]] = false;
		$existing[self::$jsAttr["mediumScreen"]] = false;
		$existing[self::$jsAttr["largeScreen"]] = false;

		$tmp = $xml->attributes()[$name];
		if (isset($tmp)) {
			$this->$name[self::$jsAttr["smallScreen"]] = ($computeValue == null) ? $tmp."" : call_user_func($computeValue, $tmp);
			$this->$name[self::$jsAttr["mediumScreen"]] = ($computeValue == null) ? $tmp."" : call_user_func($computeValue, $tmp);
			$this->$name[self::$jsAttr["largeScreen"]] = ($computeValue == null) ? $tmp."" : call_user_func($computeValue, $tmp);
			// Set the boolean to true. Allow next function to check if the mandatory attribute are present
			$existing[self::$jsAttr["smallScreen"]] = true;
			$existing[self::$jsAttr["mediumScreen"]] = true;
			$existing[self::$jsAttr["largeScreen"]] = true;
		}
		$tmp = $xml->attributes()[$name.ucfirst(self::$jsAttr["mediumScreen"])];
		if (isset($tmp)) {
			$this->$name[self::$jsAttr["mediumScreen"]] = $computeValue == null ? $tmp."" : call_user_func($computeValue, $tmp);
			$this->$name[self::$jsAttr["largeScreen"]] = $this->$name[self::$jsAttr["mediumScreen"]];
			// Set Boolean
			$existing[self::$jsAttr["mediumScreen"]] = true;
			$existing[self::$jsAttr["largeScreen"]] = true;
		}
		$tmp = $xml->attributes()[$name.ucfirst(self::$jsAttr["largeScreen"])];
		if (isset($tmp)) {
			$this->$name[self::$jsAttr["largeScreen"]] = $computeValue == null ? $tmp."" : call_user_func($computeValue, $tmp);
			// Set Boolean
			$existing[self::$jsAttr["largeScreen"]] = true;
		}

		return $existing;
	}

	protected function setTransResource(string $fileName) {

		$fileName = preg_replace('/[\/\w\d]*\/config\/\.\.\/Uis\//', '', $fileName);

		$this->transResource = preg_replace('/\.xml/', '', $fileName);
	}


	// Method
	public function addStyleClass(string $arg, string $prefix = null) {

		if ($prefix != null) {
			array_push($this->styleClass, self::$htmlClass[$arg]."-".$prefix);
		}
		else {
			array_push($this->styleClass, self::$htmlClass[$arg]);
		}

	}

	public function addScriptClass(string $arg, string $prefix = null) {

		if ($prefix != null) {
			array_push($this->scriptClass, self::$htmlClass[$arg]."-".$prefix);
		}
		else {
			array_push($this->scriptClass, self::$htmlClass[$arg]);
		}

	}

	public function addModelerAttr(string $key, array $values, callable $computeValue = null) {
		
		$this->attributes[self::$jsAttr[$key]."-".self::$jsAttr["smallScreen"]] =
			($computeValue == null) ? $values[self::$jsAttr["smallScreen"]] :
				call_user_func($computeValue, $values[self::$jsAttr["smallScreen"]]);
		

		$this->attributes[self::$jsAttr[$key]."-".self::$jsAttr["mediumScreen"]] =
			($computeValue == null) ? $values[self::$jsAttr["mediumScreen"]] :
				call_user_func($computeValue, $values[self::$jsAttr["mediumScreen"]]);
		

		$this->attributes[self::$jsAttr[$key]."-".self::$jsAttr["largeScreen"]] =
			($computeValue == null) ? $values[self::$jsAttr["largeScreen"]] :
				call_user_func($computeValue, $values[self::$jsAttr["largeScreen"]]);

	}

	public function addModelerAttrOneScreen(string $key, array $values, string $screenSuffix, callable $computeValue = null) {
		
		$this->attributes[self::$jsAttr[$key]."-".self::$jsAttr[$screenSuffix]] =
			($computeValue == null) ? $values[self::$jsAttr[$screenSuffix]] :
				call_user_func($computeValue, $values[self::$jsAttr[$screenSuffix]]);
		

		$this->attributes[self::$jsAttr[$key]."-".self::$jsAttr["mediumScreen"]] =
			($computeValue == null) ? $values[self::$jsAttr["mediumScreen"]] :
				call_user_func($computeValue, $values[self::$jsAttr["mediumScreen"]]);
		

		$this->attributes[self::$jsAttr[$key]."-".self::$jsAttr["largeScreen"]] =
			($computeValue == null) ? $values[self::$jsAttr["largeScreen"]] :
				call_user_func($computeValue, $values[self::$jsAttr["largeScreen"]]);

	}

	public function addHtmlAttr(string $key, string $value) {
		$this->attributes[$key] = $value;
	}

	protected function generateAttributes() {
		$tmp = "";

		foreach ($this->styleClass as $c) {
			$tmp .= "$c ";
		}

		$res = 'class="'.substr($tmp, 0, -1).'" ';

		$tmp = "";

		foreach ($this->scriptClass as $c) {
			$tmp .= "$c ";
		}

		$res .= 'modeler-class="'.substr($tmp, 0, -1).'" ';

		foreach ($this->attributes as $attribute => $value) {
			$res .= $attribute.'="'.$value.'" ';
		}

		return substr($res, 0, -1);
	}

	protected function transText(\Pimple\Container $container, string $id) {

		$request = $container['request_stack']->getCurrentRequest();

		$locale = new \Locale($request->get("locale"));

		$tmp = $container["translator"]->trans($locale, $this->getTransResource(), $id);

		if ($tmp["country"] != $locale->getCountry() || $tmp["language"] != $locale->getLanguage()) {
			throw new TranslationException($this->xmlNode, $this->xmlFileName, $id);
		}

		return $tmp["translation"];
	}

	protected function abortRender($msg) {
		throw new RenderException($this->xmlNode, $this->xmlFileName, $msg);
	}

	// Abstract method
	abstract public function renderHtml(\Pimple\Container $container);

}
