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

}