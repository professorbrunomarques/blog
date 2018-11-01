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

require_once("route-site.php");
require_once("route-admin-user.php");
require_once("route-admin-post.php");
require_once("route-admin-category.php");

$app->run();
