<?php

namespace Modeler\Parser\Exception;

class ParsingException extends \Exception {
	
	function __construct(\SimpleXmlElement $xml, string $filename, string $msg) {

		$node = dom_import_simplexml($xml);
		$nbLine = $node->getLineNo();

		parent::__construct("Parsing error in file $filename at $nbLine: $msg", 500);

	}
}