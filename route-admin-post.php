<?php
use \Blog\PageAdmin;
use \Blog\model\User;
use \Blog\model\Post;
use \Blog\model\Category;
use \Blog\helper\Check;

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

