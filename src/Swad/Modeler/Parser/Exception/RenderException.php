<?php

namespace Modeler\Exception;

class RenderException extends \Exception {
	
	function __construct(\SimpleXmlElement $xml, string $filename, string $msg) {

		$node = dom_import_simplexml($xml);
		$nbLine = $node->getLineNo();

		parent::__construct("Error in rendering templates: $msg in file: $filename at line $nbLine", 500);

	}
}