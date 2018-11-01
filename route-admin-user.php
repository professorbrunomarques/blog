<?php
use \Blog\PageAdmin;
use \Blog\model\User;
use \Blog\helper\Check;


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
