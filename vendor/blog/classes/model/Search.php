<?php

namespace Blog\model;

use \Blog\DB\Sql;
use \Blog\Model;

class Search extends Model {
    
    public function getPostsPage ($page = 1, $itensPerPage = 4)
    {

        $start = ($page -1)* $itensPerPage;
        $sql =  new Sql();
        $results = $sql->select("SELECT sql_calc_found_rows P.post_title, P.post_name, P.post_image, P.post_author, P.post_text, P.post_date, P.cat_id, C.cat_name, C.cat_title
            FROM tb_posts AS P 
            INNER JOIN tb_categories AS C ON P.cat_id = C.cat_id
            WHERE P.post_title LIKE :search1 OR P.post_text LIKE :search2 ORDER BY P.post_date DESC
            LIMIT $start, $itensPerPage;",array(
            ":search1"=>'%'.$this->getsearch().'%',    
            ":search2"=>'%'.$this->getsearch().'%'    
        ));
        
        $resultTotal = $sql->select("SELECT FOUND_ROWS() as nrtotal;");

        return array(
            "data"=>$results,
            "total"=>(int)$resultTotal[0]["nrtotal"],
            "pages"=>ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        );
    }

}
