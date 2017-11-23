<?php

namespace Modeler\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Doctrine\Common\Annotations\AnnotationReader;

use Modeler\Color;

use Modeler\Generator\Html\Node\Screen;

use Modeler\Generator\Html as GeneratorHtml;

use Modeler\Parser;
use Modeler\Parser\Ui\Node\AbstractNode;
use Modeler\Parser\Ui\Node\Segment;
use Modeler\Parser\Ui\Attribute\Style;
use Modeler\Locale;

class Html implements ServiceProviderInterface {


	// Attribute
	private $app;
	private $variable;


	/**
	 * @param Container $container
	 */
	public function register(Container $container) {

		// Link the app and the provider
		$container['modeler.html'] = $this;
		$this->app = $container;

		Parser::$screenSuffix		= $container["modeler.screen.prefix"];
		Parser::$value 				= $container["modeler.attribute.value"];

		GeneratorHtml::$class		= $container["modeler.website.html.class"];
		GeneratorHtml::$attribute	= $container["modeler.website.js.attribute"];		

		AbstractNode::$translator = $container["translator"];
		AbstractNode::$styleDirectory = $container["modeler.ui.directory"]."/Styles/";
		Color::$directory = $container["modeler.color.directory"];
		Segment::$directory = $container["modeler.ui.directory"]."/Segments/";

		$this->variable["charset"] = $this->app["modeler.website.variable.charset"];
		$this->variable["css"] = $this->app["modeler.css"]->generateLink();
		$this->variable["js"] = $this->app["modeler.js"]->generateLink();

	}

	private function replaceVariable($variableName, $value, $string) {

		return preg_replace("(\{\{\s*$variableName\s*\}\})", $value, $string);

	}

	private function render(string $fileName, array $variables) {

		// Load the skeleton of a HTML5 page
		$skeleton = file_get_contents($this->app["modeler.website.html.skeleton"]);

		// Create the object
		$nodes = Screen::createFromXmlFile($fileName);

		// Replace the body with the render generate form the XML template
		$result = $this->replaceVariable("body", $nodes->render($variables), $skeleton);

		// Match all other variable
		preg_match_all('/\{\{\s*(\w+)\s*\}\}/', $skeleton, $matches);

		// List the matches
		foreach ($matches[1] as $match) {

			// Set the match to "" if not present
			if (! isset($variables[$match])) {
				$variables[$match] = "";
			}

			// Replace the variable by its value
			$result = $this->replaceVariable($match, $variables[$match], $result);
		}

		// return the result
		return $result;

	}



	public function renderError($code) {
		
		return $this->render($this->app["modeler.website.error.directory"]."/$code.xml", $this->variable);

	}

	public function renderPage($fileName, array $variable) {

		$locale = new Locale($variable["locale"]);

		$transFirstMessage = $this->app["translator"]->trans($locale, "firstMessage")["translation"];
		$this->variable["jsDisabledMessage"] = nl2br($transFirstMessage["jsDisabled"]);
		$this->variable["loadingMessage"] = $transFirstMessage["loading"];


		$this->variable["js"] = $this->app["modeler.js"]->generateMessage($locale).$this->variable["js"];

		return $this->render($this->app["modeler.ui.directory"]."/$fileName.xml", array_merge($variable, $this->variable));
	
	}
}
