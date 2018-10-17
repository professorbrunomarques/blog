<?php
require_once './vendor/autoload.php';

use \Slim\Slim;
use \Blog\Page;
use \Blog\PageAdmin;

$app = new \Slim\Slim();
$app->get('/', function(){
    
    $page = new Page();
    $page->setTpl("index");

});
$app->get('/admin', function(){
    
    $page = new PageAdmin();
    $page->setTpl("index");

});
$app->get('/admin/login', function(){
    
    $page = new PageAdmin();
    $page->setTpl("login");

});
$app->run();