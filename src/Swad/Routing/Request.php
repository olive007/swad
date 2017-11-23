<?php

namespace Swad\Routing;

class Request {

	// Attribute
	private $get;
	private $post;
	private $cookie;
	private $files;
	private $server;


	// Constructor
	public function __construct(array $get, array $post, array $cookie, array $files, array $server) {
		$this->server = $server;
	}


	// Class function
	public static function createFormGlobal() {
		return new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
	}


	// Getter
	public function getUrI() {
		return $this->server['REQUEST_URI'];
	}

	public function getClientAddr() {
		return $this->server['REMOTE_ADDR'];
	}

}