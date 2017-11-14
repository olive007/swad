#!/usr/bin/env php

<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = [];
$config['controller.directory'] = __DIR__.'/Controllers';

use Devolive\Application;
use Devolive\Testor;

$app = new Application($config);

exit(Testor::testAll($app));
