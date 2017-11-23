<?php

namespace Api\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Post extends HttpMethod {

	public function __construct(array $values) {
		parent::__construct($values);
		$this->methodType = "post";
	}

}
