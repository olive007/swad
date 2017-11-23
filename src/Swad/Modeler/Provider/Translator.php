<?php

namespace Modeler\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Modeler\Locale;

class Translator implements ServiceProviderInterface {

	/**
	 * @param Container $app
	 */
	public function register(Container $app) {

		$app["translator"] = $this;
		$this->app = $app;


	}

	public function trans(Locale $locale, string $resource, string $key = "") {

		$language = $locale->getLanguage();
		$country = $locale->getCountry();

		$directory = $this->app["modeler.translation.directory"]."/$language/$country/";

		$fileName = $directory."$resource.yml";

		// Test if translation exist for a another country
		if (! is_file($fileName)) {

			// Open the language folder
			if ($handle = opendir($this->app["modeler.translation.directory"]."/$language")) {

				// List the dir
				while (false !== ($dir = readdir($handle))) {

					// Check if that's a real dir
					if ($dir === '.' || $dir === '..') {
						continue;
					}

					$country = $dir;

					$directory = $this->app["modeler.translation.directory"]."/$language/$country/";
					$fileName = $directory."$resource.yml";

					if (is_file($fileName)) {
						break;
					}

				}
				closedir($handle);
			}

		}

		// Test if default translation is present
		if (! is_file($fileName)) {
			$language = $this->app["modeler.translator.default.language"];
			$country = $this->app["modeler.translator.default.country"];
			$directory = $this->app["modeler.translation.directory"]."/$language/$country/";
			$fileName = $directory."$resource.yml";
		}

		// Abort if no transtation found
		if (! is_file($fileName)) {
			$this->app->abort(404);
		}

		$res = [];
		$res["language"] = $language;
		$res["country"] = $country;
		$translation = \yaml_parse_file ($fileName);

		if ($key !== "") {
			$translation = $translation[$key];
		}
		$res["translation"] = $translation;

		return $res;
	}

}
