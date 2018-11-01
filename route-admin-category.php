<?php
use \Blog\PageAdmin;
use \Blog\model\User;
use \Blog\model\Category;
use \Blog\helper\Check;

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