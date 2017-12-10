<?php

namespace Swad\Controller;

use Swad\Application;

abstract class AbstractController {


	// Attribute
	protected $app;
	protected $em;
	private $prefix;


	// Construtor
	public function __constructor(Application $app) {
		$this->app = $app;
	}


	// Setter
	public function setPrefix(string $arg) {
		$this->prefix = $arg;
	}

	public function connect(Application $app) {

		/*
		$r = new \ReflectionClass($this);
		
		$methods = $r->getMethods();

		AnnotationRegistry::registerLoader('class_exists');

		$annotationReader = new AnnotationReader();

		foreach ($methods as $method) {

			$annotations = $annotationReader->getMethodAnnotations($method);

			foreach ($annotations as $annotation) {
				$annotation->action($factory, $method, $this);
			}
		}
		
		return $factory;

		/**/
	}


}