<?php
require_once './vendor/autoload.php';

use \Slim\Slim;
use \Blog\Page;

$app = new \Slim\Slim();
$app->get('/', function(){
    
    $page = new Page();
    $page->setTpl("index");

});
$app->run();