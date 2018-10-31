<?php
session_start();

require_once './vendor/autoload.php';

use \Slim\Slim;
use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\User;
use \Blog\model\Post;
use \Blog\model\Category;
use \Blog\helper\Check;

$app = new \Slim\Slim();
$app->get('/', function(){
    
    require_once("./vendor/blog/functions.php");

    $posts = Post::getPosts(4);
    $page = new Page();
    $page->setTpl("index", array(
        "posts"=>$posts
    ));

});
$app->get('/noticias/:noticia', function($noticia){
    $posts = Post::getPosts(4);
    $page = new Page();
    $page->setTpl("page");
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
// USER CREATE
$app->get('/admin/users/create', function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->post('/admin/users/create', function(){
    User::verifyLogin();
    //Pega os dados do formulário e faz um tratamento prévio
    $data = $_POST;
    $data = array_map("strip_tags", $data);
    $data = array_map("trim", $data);
    $data["email"] = strtolower($data["email"]);
    $data["level"] = (isset($data["level"])) ? 1 : 0;
    
    if(!Check::email($data["email"])){
        throw new \Exception("formato do e-mail é inválido!");
    }
    
    $user = new User();
    $user->setData($data);
    $user->save();  
    header("location: /admin/users");
    exit();
});

//USER UPDATE
$app->get('/admin/users/:id_user', function($id_user){
    User::verifyLogin();
    $user = User::getUserById($id_user);
    $page = new PageAdmin();
    $page->setTpl("users-update", array(
        "user"=>$user[0]
    ));
});

$app->post('/admin/users/:id_user', function($id_user){
    User::verifyLogin();
    //Pega os dados do formulário e faz um tratamento prévio
    $data = $_POST;
    $data = array_map("strip_tags", $data);
    $data = array_map("trim", $data);
    $data["email"] = strtolower($data["email"]);
    $data["level"] = (isset($data["level"])) ? 1 : 0;
    if(!Check::email($data["email"])){
        throw new \Exception("formato do e-mail é inválido!");
    }
    $user = new User();
    $data = User::update($data, $id_user);
        
    header("location: /admin/users");
    exit();
});

//USER DELETE
$app->get('/admin/users/:id_user/delete', function($id_user){
    User::verifyLogin();
    $user = User::deleteUserById($id_user);
    header("location: /admin/users");
    exit();
});


//POST LIST
$app->get('/admin/posts', function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $posts = Post::listAll();
    $page->setTpl("posts", array(
        "posts"=>$posts
    ));
});
//POST CREATE
$app->get('/admin/posts/create', function(){
    User::verifyLogin();
    $categorys = Category::listAll();
    $page = new PageAdmin();
    $page->setTpl("posts-create", array(
        "categorys"=>$categorys
    ));
});

$app->post('/admin/posts/create', function(){
    User::verifyLogin();
    //Armazena na variável data o conteúdo do formulário
    $data = $_POST;
    //Armazenar na variável o conteudo do POST_TEXT, evitando a remoção das tags
    $post_texto = $data["post_text"];
    //Remove tags e espaços vazios
    $data = array_map("strip_tags", $data);
    $data = array_map("trim", $data);
    //Acrecentando o campo POST_NAME porém no formato URI
    $data["post_name"] = Check::Name($data["post_title"]);
    //Retorno o conteúdo original do POST_TEXT
    $data["post_text"] = $post_texto;
    //Verifica se a caixa para exibição do post foi ativada.
    $data["post_status"] = (isset($data["post_status"])) ? 1 : 0;
    unset($data["_wysihtml5_mode"]);
    $post = new Post();
    $post->setData($data);
    $post->save();
    header("Location: /admin/posts");
    exit();
});

//POST UPDATE
$app->get('/admin/posts/:post_id', function($post_id){
    User::verifyLogin();
    $post = Post::getPostById($post_id);
    $categorys = Category::listAll();
    $page = new PageAdmin();
    $page->setTpl("posts-update", array(
        "post"=>$post[0],
        "categorys"=>$categorys
    ));
});
$app->post('/admin/posts/:post_id', function($post_id){
    User::verifyLogin();
    //Armazena na variável data o conteúdo do formulário
    $data = $_POST;
    //Armazenar na variável o conteudo do POST_TEXT, evitando a remoção das tags
    $post_texto = $data["post_text"];
    //Remove tags e espaços vazios
    $data = array_map("strip_tags", $data);
    $data = array_map("trim", $data);
    //Acrecentando o campo POST_NAME porém no formato URI
    $data["post_name"] = Check::Name($data["post_title"]);
    //Retorno o conteúdo original do POST_TEXT
    $data["post_text"] = $post_texto;
    //Verifica se a caixa para exibição do post foi ativada.
    $data["post_status"] = (isset($data["post_status"])) ? 1 : 0;
    unset($data["_wysihtml5_mode"]);
    $post = new Post();
    $post->setData($data);
    $post->update($post_id);
    header("Location: /admin/posts");
    exit();
    
});
//POST DELETE
$app->get('/admin/posts/:post_id/delete', function($post_id){
    User::verifyLogin();
    $res = Post::delete($post_id);
    header("Location: /admin/posts");
    exit();
});
//CATEGORIES SELECT
$app->get('/admin/categories', function(){
    User::verifyLogin();
    $categories = Category::listAll();
    $page = new PageAdmin();
    $page->setTpl('categories', array(
        "categories"=>$categories
    ));
});

//CATEGORIES CREATE
$app->get('/admin/categories/create', function(){
    User::verifyLogin();
    $categories = Category::listAll();
    $page = new PageAdmin();
    $page->setTpl('categories-create', array(
        "categories"=>$categories
    ));
});
$app->post('/admin/categories/create', function(){
    User::verifyLogin();
    $data = $_POST;
    $data["cat_name"] = Check::Name($data["cat_title"]);
    $cat = new Category();
    $cat->setData($data);
    $cat->save();
    header("Location: /admin/categories");
    exit();

});

//CATEGORIES UPDATE
$app->get('/admin/categories/:cat_id', function($cat_id){
    User::verifyLogin();
    $categories = Category::listAll();
    $category = Category::getById($cat_id);
    $page = new PageAdmin();
    $page->setTpl('categories-update', array(
        "categories"=>$categories,
        "category"=>$category
    ));
});
$app->post('/admin/categories/:cat_id', function($cat_id){
    User::verifyLogin();
    $data = $_POST;
    $data["cat_name"] = Check::Name($data["cat_title"]);
    $cat = new Category();
    $cat->setData($data);
    $cat->update($cat_id);
    header("Location: /admin/categories");
    exit();
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
$app->get("/posts/:post_name", function($post_name){
   $page = new Page();
   $page->setTpl("posts");
});

$app->run();
