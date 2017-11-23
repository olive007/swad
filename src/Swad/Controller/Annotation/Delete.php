<?php

namespace Api\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Delete extends HttpMethod {

	public function __construct(array $values) {
		parent::__construct($values);
		$this->methodType = "delete";
	}

}
