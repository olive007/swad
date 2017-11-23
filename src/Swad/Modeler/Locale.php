<?php

namespace Modeler;

class Locale {

	// Attribute
	private $language;
	private $country;


	// Constructor
	public function __construct(string $str) {

		$tmp = preg_split("/_/", $str);

		if (count($tmp) != 2) {
			$tmp = preg_split("/-/", $str);
		}

		$this->language = strtolower($tmp[0]);
		$this->country = strtoupper($tmp[1]);

		if (count($tmp) != 2) {
			throw new Exception("Error Processing Request", 1);
		}

	}



	// Getter
	public function getLanguage() : string {
		return $this->language;
	}

	public function getCountry() : string {
		return $this->country;
	}


}
