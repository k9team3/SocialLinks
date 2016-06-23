<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23.06.2016
 * Time: 16:20
 */


include ('./config/config.php');
include ('./config/request.php');
include('./transforms/calls.php');
include('./transforms/facebook.php');
include('./transforms/google.php');
include ('./maltego/maltegotransform.php');



$container = $app->getContainer();

$container['entity'] = function($c){

    return new MaltegoEntity();
};

$container['transform'] = function($c){

    return new MaltegoTransform();
};
$container['input'] = function($c){

    return new MaltegoTransformInput();
};
$container['request'] = function($c){

    return new Request();
};
$container['config'] = function($c){

    return new Config();
};
$container['calls'] = function($c){

    return new Calls($c['entity'],$c['transform'],$c['request']);
};
$container['facebook'] = function($c){

    return new Facebook($c['calls'],$c['input'],$c['config']);
};
$container['google'] = function($c){

    return new Google($c['calls'],$c['input'],$c['config']);
};

