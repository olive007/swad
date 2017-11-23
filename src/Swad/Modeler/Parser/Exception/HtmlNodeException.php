<?php

namespace Modeler\Exception;

class HtmlNodeException extends \Exception {
	
	function __construct(\SimpleXmlElement $xml, string $filename, string $error) {

		$node = dom_import_simplexml($xml);
		$nbLine = $node->getLineNo();

		parent::__construct("Error in file: $filename at line $nbLine: $error", 500);

	}
}