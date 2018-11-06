<?php
 setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
 date_default_timezone_set('America/Sao_Paulo'); 

use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\Post;
use \Blog\model\User;
use \Blog\model\Category;
use \Blog\model\Comment;
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
//EXIBIR POSTS POR CATEGORIA
$app->get("/category/:cat_name", function(string $cat_name){
    //Pega a página atual
    $page = (isset($_GET["page"]))? (int)$_GET["page"]: 1;

    //Gera um objeto e cria os metodos gets de acordo com o cat_name
    $categoria = new Category();
    $data = $categoria->getCatByName($cat_name);
    $categoria->setData($data[0]);
    
    //Faz a paginação dos dados
    $pagination = $categoria->getPostsPage($page, 8);

    $pages = [];
    if($pagination['pages'] > 1){
        for ($i=1; $i <= $pagination['pages']; $i++) { 
            array_push($pages,[
                'link'=>'/category/'.$categoria->getcat_name().'?page='.$i,
                'page'=>$i
            ]);
        }
    }
    $page = new Page();
    $page->setTpl("categories", [
        "posts"=>$pagination["data"], 
        "category"=>$data[0]["cat_title"],
        "pages"=>$pages
        ]);
});
// EXIBIR POST NO SITE
$app->get("/post/:post_name", function($post_name){
    require_once("./vendor/blog/functions.php");
    $post = Post::getPostByName($post_name);
    $page = new Page($post);
    $page->setTpl("posts", $post);
 });

 //ROTAS PARA TESTES
 $app->get("/teste", function(){
   
    echo strftime('%A, %d de %B de %Y', strtotime('today'));
 });