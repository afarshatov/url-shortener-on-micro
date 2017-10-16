<?php

$baseDir = __DIR__ . DIRECTORY_SEPARATOR;
require_once 'vendor/autoload.php';

$app = \Micro\App::getInstance();
$app->run($baseDir . Micro\App::APP_DIR);