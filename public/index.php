<?php

require_once __DIR__ . "/../vendor/autoload.php";

//var_dump(class_exists('app\core\Application')); // Should return true
use app\core\Application;

$app = new Application();





$app->run();