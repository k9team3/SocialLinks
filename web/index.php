<?php

namespace mpoellath\sociallinks;

use Slim\App;
require_once('../vendor/autoload.php');


$app = new App();

require __DIR__.'/dependencies.php';
require __DIR__.'/routes.php';

$app->run();




