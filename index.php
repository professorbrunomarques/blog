<?php
session_start();

require_once './vendor/autoload.php';

use \Slim\Slim;
use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\User;

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

$app->get('/admin/users', function(){
    User::verifyLogin();
    $users = User::listAll();
    $page = new PageAdmin();
    $page->setTpl("users", array(
        "users"=>$users
    ));
});

$app->get('/admin/users/create', function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->post('/admin/users/create', function(){
    User::verifyLogin();
    $data = User::save($_POST);
    if(is_array($data)){
        $page = new PageAdmin();
        $page->setTpl("users-create-error", array(
            "data"=>$data
        ));
    }else{
        header("location: /admin/users");
        exit();
    }
});

$app->get('/admin/users/:id_user', function($id_user){
    User::verifyLogin();
    $user = User::getUserById($id_user);
    $page = new PageAdmin();
    $page->setTpl("users-update", array(
        "user"=>$user[0]
    ));
});
$app->get('/admin/users/:id_user/delete', function($id_user){
    User::verifyLogin();
    $user = User::deleteUserById($id_user);
    header("location: /admin/users");
    exit();
});
$app->run();
