<?php

namespace Controller;

use Swad\Controller\AbstractController;


/**
 * @Route("test")
 */
class Website extends AbstractController {

	public function helloWord() {
		return "Salut";
	}

}