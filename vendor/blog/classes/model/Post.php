<?php

namespace Blog\model;

use \Blog\helper\Check;
use \Blog\helper\Upload;
use \Blog\DB\Sql;
use \Blog\Model;

class Post extends Model {
    /**
     * Lista todas as postagens ordenadas em ordem decrescente 
     */
    public static function listAll()
    {
        $sql = new Sql;
        return $sql->select("SELECT * FROM tb_posts ORDER BY post_id DESC");
    }
    public function save()
    {
        $imagem = $_FILES["post_image"];
        $upload = new Upload();
        $post_image = $upload->image($imagem, $this->getpost_name());
        
        $sql = new Sql();
        $sql->query("INSERT INTO tb_posts (post_title, post_name, post_image, post_author, post_text, cat_id, post_status) 
        VALUES (:post_title, :post_name, :post_image, :post_author, :post_text, :cat_id, :post_status)", array(
            ":post_title"=>$this->getpost_title(),  
            ":post_name"=>$this->getpost_name(), 
            ":post_image"=>$post_image, 
            ":post_author"=>$this->getpost_author(),
            ":post_text"=>$this->getpost_text(),
            ":cat_id"=>$this->getcat_id(), 
            ":post_status"=>$this->getpost_status()
        ));
    }
}