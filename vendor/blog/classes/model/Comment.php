<?php

namespace Blog\model;

use \Blog\Model;
use \Blog\DB\Sql;
use \Blog\model\Post;

class Comment extends Model {

    public static function listAll(int $post_id):array
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_comments WHERE post_id = :post_id", array(
            ":post_id"=>$post_id
        ));
    }

    public function save()
    {
        $sql = new Sql();
        $sql->query("INSERT INTO tb_comments (comment_text, post_id, id_user) VALUES (:comment_text, :post_id, :id_user)", array(
            ":comment_text"=>$this->getcomment_text(),
            ":post_id"=>$this->getpost_id(),
            ":id_user"=>$this->getid_user()
        ));
    }
    public function update()
    {
        echo "O comment_id é ".$this->getcomment_id();
        $sql = new Sql();
        $sql->query("UPDATE tb_comments SET comment_text = :comment_text WHERE comment_id = :comment_id;",[
            ":comment_text"=>$this->getcomment_text(),
            ":comment_id"=>$this->getcomment_id()
        ]);
    }

     
}