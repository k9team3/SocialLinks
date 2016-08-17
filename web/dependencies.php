<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23.06.2016
 * Time: 16:20
 */


include ('./config/config.php');
include('./config/send.php');
include('./transforms/calls.php');
include('./transforms/facebook.php');
include('./transforms/google.php');
include ('./maltego/maltegotransform.php');



$container = $app->getContainer();

$container['entity'] = function($c){

    return new \mpoellath\sociallinks\maltego\MaltegoEntity();
};
$container['transform'] = function($c){

    return new \mpoellath\sociallinks\maltego\MaltegoTransform();
};
$container['input'] = function($c){

    return new \mpoellath\sociallinks\maltego\MaltegoTransformInput();
};
$container['send'] = function($c){

    return new \mpoellath\sociallinks\config\Send();
};
$container['config'] = function($c){

    return new  \mpoellath\sociallinks\config\Config();
};
$container['calls'] = function($c){

    return new  \mpoellath\sociallinks\transforms\Calls($c['entity'],$c['transform'],$c['send']);
};
$container['facebook'] = function($c){

    return new \mpoellath\sociallinks\transforms\Facebook($c['calls'],$c['input'],$c['config']);
};
$container['google'] = function($c){

    return new \mpoellath\sociallinks\transforms\Google($c['calls'],$c['input'],$c['config']);
};

