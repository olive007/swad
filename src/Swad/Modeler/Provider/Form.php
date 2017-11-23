<?php

namespace Modeler\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

use Modeler\Parser\Form as Parser;

class Form implements ServiceProviderInterface {


	// Attribute
	private $app;
	private $annotationReader;


	/**
	 * @param Container $app
	 */
	public function register(Container $app) {

		$app['modeler.form'] = $this;
		$this->app = &$app;
		

		$this->annotationReader = new AnnotationReader();
		// AnnotationReader::addGlobalIgnoredName('Entity');
		// AnnotationReader::addGlobalIgnoredName('Table');


	}


	public function get(string $id) {

		$file = $this->app["modeler.form.directory"]."/$id.xml";

		// Load the xml form the file
		$xml = simplexml_load_file($file) or die("Error: Cannot create object");
		
		// Create the object
		$form = new Parser\Form($xml, $file);

		return $form;
	}


}
