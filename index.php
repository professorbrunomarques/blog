<?php
session_start();

require_once './vendor/autoload.php';

use \Slim\Slim;
use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\Model\User;

$app = new \Slim\Slim();
$app->get('/', function(){
    
    $page = new Page();
    $page->setTpl("index");

});
$app->get('/admin', function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");

});
$app->get('/admin/login', function(){
    
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl("login");

});
$app->post('/admin/login', function(){
    
    User::login($_POST["login"], $_POST["password"]);
    
    header("location: /admin");
    exit();
});

$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;

});
$app->run();