<?php


require_once('../vendor/autoload.php');


use Slim\App;

$app = new App();

require __DIR__.'/dependencies.php';
require __DIR__.'/routes.php';

$app->run();




