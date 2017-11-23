<?php

// namespace Modeler\HtmlNode;

// use Modeler\Exception\MandatoryAttributeException;

// abstract class AbstractLayout extends AbstractContainer {


// 	// Attribute
// 	protected $weight;



// 	// Constructor
// 	public function __construct(
// 		\SimpleXMLElement $xml,
// 		string $xmlFileName,
// 		callable $attrInherited,
// 		callable $attrAdditional,
// 		AbstractContainer $container = null) {

// 		parent::__construct($xml, $xmlFileName, $attrInherited, function($xml, $xmlFileName, AbstractNode $obj) use ($attrAdditional) {

// 			call_user_func($attrAdditional, $xml, $xmlFileName, $obj);

// 		}, $container);

// 	}

// }