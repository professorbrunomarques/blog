<?php

namespace Blog\model;

use \Blog\helper\Check;
use \Blog\helper\Upload;
use \Blog\DB\Sql;
use \Blog\Model;

class Post extends Model {
    /**
     * Retorna o total de Postagens
     */
    public static function getTotalPosts(){
        $sql = new Sql();
        $total =  $sql->select("SELECT count(*) as total FROM tb_posts");
        return $total[0]["total"];
    }

    /**
     * Lista todas as postagens ordenadas em ordem decrescente 
     */
    public static function listAll(int $itensPerPage = 10)
    {
        $sql = new Sql;
        return $sql->select("SELECT * FROM tb_posts ORDER BY post_id DESC LIMIT $itensPerPage");
    }

    public static function getPosts(int $itensPerPage)
    {
        $sql = new Sql();
        $results = $sql->select("
        SELECT *
            FROM tb_posts AS P 
            INNER JOIN tb_categories AS C ON P.cat_id = C.cat_id
            WHERE P.post_status = 1 ORDER BY P.post_id DESC LIMIT :itens;", array(
            ":itens"=>$itensPerPage
        ));
        return $results;
    }
    
    public static function getPostById(int $post_id)
    {
        $sql = new Sql;
        return $sql->select("SELECT * FROM tb_posts WHERE post_id = :post_id", array(
            ":post_id"=>$post_id
        ));
    }
    public static function getPostByName(string $post_name)
    {
        $sql = new Sql;
        $result =  $sql->select("
            SELECT P.post_id, P.post_title, P.post_name, P.post_image, P.post_author, P.post_text, P.post_date, P.cat_id, C.cat_name, C.cat_title
            FROM tb_posts AS P 
            INNER JOIN tb_categories AS C ON P.cat_id = C.cat_id
            WHERE P.post_name = :post_name", 
        array(
            ":post_name"=>$post_name
        ));
        return $result[0];
    }
    public static function getPostByCatName(string $cat_name)
    {
        $sql = new Sql;
        $results =  $sql->select("
            SELECT P.post_title, P.post_name, P.post_image, P.post_author, P.post_text, P.post_date, P.cat_id, C.cat_name, C.cat_title
            FROM tb_posts AS P 
            INNER JOIN tb_categories AS C ON P.cat_id = C.cat_id
            WHERE C.cat_name = :cat_name", 
        array(
            ":cat_name"=>$cat_name
        ));
        return $results;
    }

    public function save()
    {
        //Armazeno o arquivo que foi enviado pelo formulario na variável $imagem
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
    public function update(int $post_id)
    {
        //Armazeno o arquivo que foi enviado pelo formulario na variável $imagem
        if($_FILES["post_image"]["name"]!= NULL){
            $imagem = $_FILES["post_image"];
            $upload = new Upload();
            $post_image = $upload->image($imagem, $this->getpost_name());
            $mudar_img = true;
        }
        $img = (!empty($post_image))?"post_image = :post_image,":"";
        
        if (isset($mudar_img)){
            $binds =array(
                ":post_title"=>$this->getpost_title(),  
                ":post_name"=>$this->getpost_name(), 
                ":post_image"=>$post_image, 
                ":post_author"=>$this->getpost_author(),
                ":post_text"=>$this->getpost_text(),
                ":cat_id"=>$this->getcat_id(), 
                ":post_status"=>$this->getpost_status(),
                ":post_id"=>$post_id
            );
        }else{
            $binds =array(
                ":post_title"=>$this->getpost_title(),  
                ":post_name"=>$this->getpost_name(),  
                ":post_author"=>$this->getpost_author(),
                ":post_text"=>$this->getpost_text(),
                ":cat_id"=>$this->getcat_id(), 
                ":post_status"=>$this->getpost_status(),
                ":post_id"=>$post_id
            );
        }
        $sql = new Sql();
        $query = "UPDATE tb_posts SET post_title = :post_title, post_name = :post_name,".$img." post_author = :post_author, post_text = :post_text, cat_id = :cat_id, post_status = :post_status WHERE post_id = :post_id;";
        $sql->query($query, $binds);
    }

    public static function delete(int $post_id)
    {
       $arquivo = $_SERVER["DOCUMENT_ROOT"].Post::getPostImage($post_id);
       if (is_file($arquivo)){
           unlink($arquivo);
        }
        
        $sql = new Sql();
        $sql->query("DELETE FROM tb_posts WHERE post_id = :post_id", array (
             ":post_id"=>$post_id
        ));
    }

    public static function getPostImage(int $post_id)
    {
        $sql = new Sql();
        $result = $sql->select("SELECT post_image FROM tb_posts WHERE post_id = :post_id", array (
            ":post_id"=>$post_id
        ));
        return $result[0]["post_image"];
    }
}

