<?php

namespace Api\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Route {


	// Attribute
	private $path;

	public function __construct(array $values) {
		$this->path = isset($values['value']) ? $values['value'] : "";
	}


	// Method
	public function action(\Pimple\Container $app, \Api\Controller\AbstractBase $ctrl) {
		$app->mount("/".$app["api.path.prefix"]."/".$this->path, $ctrl);
	}

}
