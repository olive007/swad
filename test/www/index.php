<?php

//ini_set('display_errors', 0);

require_once __DIR__.'/../../vendor/autoload.php';

$config = require __DIR__.'/../config.php';

$app = new Application($config);

$app->run();
