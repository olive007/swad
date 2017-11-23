<?php

namespace Modeler\Parser\Ui\Node;

use Modeler\Locale;

use Modeler\Parser;
use Modeler\Parser\Ui\Attribute\AbstractAttribute;
use Modeler\Parser\Ui\Attribute\Style;

abstract class AbstractNode {

	// Class variable
	static public	$namespace;
	static public	$translator;
	static public	$styleDirectory;

	// Attributes
	private $xmlNode;
	private $xmlFileName;
	private $container;
	private $attributes;
	protected $translationResource;
	protected $personnalAttribute;


	// Constructor
	protected function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		$this->initFunctionTab();

		// Link the attributes
		$this->container = $container;
		$this->xmlNode = $xmlNode;
		$this->xmlFileName = $xmlFileName;

		// Initialize the variable
		$this->attributes = [];

		foreach ($xmlNode->attributes() as $name => $value) {

			$tmp = explode("-", $name);

			if ($this->personnalAttribute[$tmp[0]]($name, $value)) {
				$className = self::$namespace."\\Attribute\\".$tmp[0];

				new $className($value, $this, isset($tmp[1])  ? $tmp[1] : "");
			}

		}

	}



	// Getter	
	abstract public function getType() : string;

	public function getContainer() : ?AbstractContainer {
		return $this->container;
	}

	public function getXmlNode() : \SimpleXMLElement {
		return $this->xmlNode;
	}

	public function getXmlFileName() : string {
		return $this->xmlFileName;
	}

	public function getTranslationResource() : string {

		$tmp = preg_replace('/[\/\w\d]*\/config\/\.\.\/Modeler\/Uis\//', '', $this->xmlFileName);

		return "Uis/".preg_replace('/\.xml/', '', $tmp);
	}

	public function getAttribute(string $id) : ?AbstractAttribute {
		return isset($this->attributes[$id]) ? $this->attributes[$id] : null;
	}



	// Method
	protected function initFunctionTab() {

		// function tab		
		$this->personnalAttribute["BorderTop"]			= function($n, $v) {return true;};
		$this->personnalAttribute["BorderRight"]		= function($n, $v) {return true;};
		$this->personnalAttribute["BorderBottom"]		= function($n, $v) {return true;};
		$this->personnalAttribute["BorderLeft"]			= function($n, $v) {return true;};
		$this->personnalAttribute["BorderRadius"]		= function($n, $v) {return true;};
		$this->personnalAttribute["Color"]				= function($n, $v) {return true;};
		$this->personnalAttribute["ColorBackground"]	= function($n, $v) {return true;};
		$this->personnalAttribute["ColorBorder"]		= function($n, $v) {return true;};
		$this->personnalAttribute["ColorFont"]			= function($n, $v) {return true;};
		$this->personnalAttribute["ColorInput"]			= function($n, $v) {return true;};
		$this->personnalAttribute["Encoding"]			= function($n, $v) {return true;};
		$this->personnalAttribute["Font"]				= function($n, $v) {return true;};
		$this->personnalAttribute["FontSize"]			= function($n, $v) {return true;};
		$this->personnalAttribute["Height"]				= function($n, $v) {return true;};
		$this->personnalAttribute["Id"]					= function($n, $v) {return true;};
		$this->personnalAttribute["MarginBottom"]		= function($n, $v) {return true;};
		$this->personnalAttribute["MarginLeft"]			= function($n, $v) {return true;};
		$this->personnalAttribute["MarginRight"]		= function($n, $v) {return true;};
		$this->personnalAttribute["MarginTop"]			= function($n, $v) {return true;};
		$this->personnalAttribute["Orientation"]		= function($n, $v) {return true;};
		$this->personnalAttribute["Overflow"]			= function($n, $v) {return true;};
		$this->personnalAttribute["PaddingTop"]			= function($n, $v) {return true;};
		$this->personnalAttribute["PaddingRight"]		= function($n, $v) {return true;};
		$this->personnalAttribute["PaddingBottom"]		= function($n, $v) {return true;};
		$this->personnalAttribute["PaddingLeft"]		= function($n, $v) {return true;};
		$this->personnalAttribute["PositionHorizontal"]	= function($n, $v) {return true;};
		$this->personnalAttribute["PositionVertical"]	= function($n, $v) {return true;};
		$this->personnalAttribute["Style"]				= function($n, $v) {
			$id = $v."";

			$newXmlFileName = AbstractNode::$styleDirectory."$id.xml";

			$xmlNode = simplexml_load_file($newXmlFileName);

			foreach ($xmlNode->children() as $name => $value) {

				$tmp = explode("-", $name);

				$className = AbstractNode::$namespace."\\Attribute\\".$tmp[0];

				new $className($value, $this, isset($tmp[1])  ? $tmp[1] : "");

			}

			return false;
		};
		$this->personnalAttribute["TextAlignHorizontal"] =	function($n, $v) {return true;};
		$this->personnalAttribute["TextAlignVertical"] =	function($n, $v) {return true;};
		$this->personnalAttribute["Weight"] =				function($n, $v) {return true;};
		$this->personnalAttribute["Width"] =				function($n, $v) {return true;};
	}

	public function addAttribute(AbstractAttribute $attr) {
		$this->attributes[$attr->getType()] = $attr;
	}

	protected function translateText(Locale $locale, string $id) {

		$tmp = self::$translator->trans($locale, $this->getTranslationResource(), $id);

		if ($tmp["country"] != $locale->getCountry() || $tmp["language"] != $locale->getLanguage()) {
			throw new TranslationException($this->xmlNode, $this->xmlFileName, $id);
		}

		return $tmp["translation"];
	}

	public function render(array $variables) : string {

		foreach ($this->attributes as $key => $attr) {
			$attr->generate();
		}

		return $this->generate($variables);
	}

	abstract public function generate(array $variables) : string;

}