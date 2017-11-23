<?php

namespace Modeler\Parser\Form;


use Pimple\Container;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Annotations\AnnotationReader;

use Doctrine\ORM\EntityManager;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;


class Form {


	// Class variable
	private static $functionTab;


	// Attributes
	private $id;
	private $xmlNode;
	private $entity;
	private $fields;
	private $annotationReader;



	// Constructor
	public function __construct(\SimpleXMLElement $xml, string $xmlFileName) {

		// Initialize the attribute
		$this->fields = [];
		$this->entity = null;
		$this->xmlNode = $xml;
		$this->id = pathinfo($xmlFileName)['filename'];


		// Initialize the annotation reader
		$this->annotationReader = new AnnotationReader();

		$this->entity = new Entity($xml->xpath("Entity")[0], $this);

		foreach ($xml->xpath("Fields")[0] as $child) {		

			// Get the name of the xml element
			$nodeName = $child->getName();

			// Set the full class name
			$className = "Modeler\\Parser\\Form\\$nodeName";

			// Create the object with the node
			$tmp = new $className($child, $this);

			// Add it into the form
			$this->fields[$tmp->getId()] = $tmp;

		}

	}



	// Getter
	public function getId() : string {
		return $this->id;
	}

	public function getField(string $id) : Field {
		return $this->fields[$id];
	}

	public function getEntity() : Entity {
		return $this->entity;
	}

	public function getAnnotationReader() : AnnotationReader {
		return $this->annotationReader;
	}



	// Class method
	public static function getFunctionTab() {

		if (self::$functionTab == null) {

			self::$functionTab = [];

			self::$functionTab["Doctrine\ORM\Mapping\Table"] = function($entity, $annotation) {
				foreach ($annotation->uniqueConstraints as $uniqueConstraint) {

				}

			};

		}

		return self::$functionTab;
	}



	// Method
	public function toDictionary(Container $app) : array {
		$res = [];

		$res["entity"] = $this->entity->getName();
		$res["fields"] = [];

		foreach ($this->fields as $id => $field) {
			if ($field->getValue() == NULL) {
				array_push($res["fields"], $field->toDictionary($app));
			}
		}

		return $res;
	}

	public function connect(Application $app, ControllerCollection $factory) : ControllerCollection {

		foreach ($this->fields as $id => $field) {

			if ($field->isValidatorPresent()) {
				$factory->post("field/".$field->getId(), function(Application $app, Request $request) use ($field) {
					$res = [];
					$res['message'] = $field->validate($app, $request);
					$code = $res['message'] == "" ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST;

					return $app->json($res, $code);
				});
			}

		}

		return $factory;

	}

	public function addRecord(EntityManager $em, ?array $data) {


		$test = function () {
			return "main";
		};

		if ($data == NULL) {
			return "wrong data request";
		}

		// Initialize variables
		$entity = NULL;
		$errorFunct = $test;
		$condition = [];
		$className = $this->getEntity()->getName();


		// Search if one fields is flaged as search condition
		foreach ($this->fields as $id => $field) {
			if ($field->isSearchCondition()) {
				$condition[$id] = $field->getValue();
			}
		}

		// Search the entity
		if (!empty($condition)) {
			$repository = $em->getRepository($className);
			$entity = $repository->findOneBy($condition);
		}
		// Or create it
		else {
			$entity = new $className();
			// and complete it with the data define in xml
			foreach ($this->fields as $id => $field) {
				if ($field->hasValue()) {
					if (isset($data[$id])) {
						return "Field not allowed";
					}
					$field->inflateEntity($entity);
				}
				if ($field->hasDefaultValue()) {
					$field->setEntityValue($entity, $field->getDefaultValue(), $em);
				}
			}
		}

		// Set value into the entity with data from request
		foreach ($data as $id => $value) {
			$this->fields[$id]->setEntityValue($entity, $value, $em, $errorFunct);
		}


		try {
			if (!empty($condition)) {
				$em->merge($entity);
			}
			else {
				$em->persist($entity);
			}
			$em->flush();
		}
/*		catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {

			$errorMsg = $e->getPrevious()->getMessage();

			$pattern = '/for\skey\s\'(\w+)\'/';
			preg_match($pattern, $errorMsg, $matches);
			print_r($matches);

			$res["msg"] = "Error:"
			$res["msg"] .= " ".$e->getPrevious()->getMessage();
		}
*/		catch (\Doctrine\DBAL\DBALException $e) {
			return call_user_func($errorFunct, $entity, $e);
			// $res["msg"] = "Error:";
			// while ($e != NULL) {
			// 	print(get_class($e)."<br>\n");
			// 	$res["msg"] .= " ".$e->getMessage()."\n<br>";
			// 	$e = $e->getPrevious();
			// }
		}

		return "toto form";
	}

}
