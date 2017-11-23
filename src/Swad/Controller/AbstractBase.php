<?php

namespace Api\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

abstract class AbstractBase implements ControllerProviderInterface {

	protected $app;
	protected $em;

	public function connect(Application $app) : ControllerCollection {

		$this->app = $app;
		$this->em = $app['orm.em'];

		$factory = $app['controllers_factory'];

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
	}


}