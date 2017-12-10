#!/usr/bin/env php

<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__.'/test/config.php';

$app = new Application($config);

$console = new Swad\Console($app, __DIR__.'/test/functionality');

exit($console->run($argv));
