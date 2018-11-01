<?php
use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\Post;
use \Blog\model\User;
use \Blog\helper\Check;

$app->get('/', function(){
    
    require_once("./vendor/blog/functions.php");

    $posts = Post::getPosts(4);
    $page = new Page();
    $page->setTpl("index", array(
        "posts"=>$posts
    ));

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

// FORGOT
$app->get('/admin/forgot', function(){

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot");
});
$app->post('/admin/forgot', function(){

    $user = User::getForgot($_POST["email"]);

    header("Location: /admin/forgot/sent");
    exit;

});

$app->get('/admin/forgot/sent', function(){

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot-sent");

});
$app->get('/admin/forgot/reset', function(){
    
    $user = User::validForgotDecrypt($_GET["code"]);

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot-reset", array(
        "name"=>$user["name"],
        "code"=>$_GET["code"]
    ));
});
$app->post('/admin/forgot/reset', function(){
    $forgot = User::validForgotDecrypt($_POST["code"]);

    User::setForgotUsed($forgot["idrecovery"]);

    $user = new User();
    $user->get((int)$forgot["id_user"]);
    $user->setNewPassword($_POST["password"]);

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot-reset-success");
});

$app->get("/post/:post_name", function($post_name){
    $post = Post::getPostByName($post_name);
    $page = new Page();
    $page->setTpl("posts", $post);
 });