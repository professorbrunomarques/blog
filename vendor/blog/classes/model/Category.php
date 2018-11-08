<?php

namespace Blog\model;

use \Blog\DB\Sql;
use \Blog\Model;

class Category extends Model {
    
    /**
     * Retorna o total de categorias
     */
    public static function getTotalCat(){
        $sql = new Sql();
        $total =  $sql->select("SELECT count(*) as total FROM tb_categories");
        return $total[0]["total"];
    }
    /**
     * Retorna um array com todos os dados da tabela categorias.
     * 
     * @return array com todas as categorias.
     */
    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_categories ORDER BY cat_title ASC");
    }
    /**
     * Retorna uma categoria informando o id_cat
     * 
     * @param int $id Informe o id da categoria a ser consultada
     * @return array com o resultado da consulta.
     */
    public static function getById(int $cat_id){
        $sql = new Sql();
        $resultado = $sql->select("SELECT * FROM tb_categories WHERE cat_id = :cat_id",array(
            ":cat_id"=>$cat_id
        ));
        return $resultado[0];
    }
    /**
     * Retorna o titulo da categoria informando o id_cat
     * 
     * @param int $id Informe o id da categoria a ser consultada
     * @return array com o resultado da consulta.
     */
    public static function getTitleById(int $cat_id){
        $sql = new Sql();
        $resultado = $sql->select("SELECT cat_title FROM tb_categories WHERE cat_id = :cat_id",array(
            ":cat_id"=>$cat_id
        ));
        return $resultado[0]["cat_title"];
    }
    /**
     * Retorna uma categoria informando o cat_name (nome da categoria em formato URL).
     * 
     * @param int $valor Informe o cat_name da categoria a ser consultada
     * @return array com o resultado da consulta.
     */
    public function getCatByName(string $valor){
        $sql = new Sql();
        $resultado = $sql->select("SELECT * FROM tb_categories WHERE cat_name = :valor",array(
            ":valor"=>$valor
        ));
        if(count($resultado)>0){
            return $resultado;
        }else{
            return "Nenhum registro encontrado.";
        }
    }
    /**
     * Insere na tabela categorias uma nova categoria
     * 
     */
    public function save() {
        var_dump($this);
        
        $sql = new Sql();
        $sql->query("INSERT INTO tb_categories (cat_id, cat_title, cat_name, cat_desc, cat_parent) VALUES (NULL, :cat_title, :cat_name, :cat_desc, :cat_parent);",array(
            ":cat_title"=>$this->getcat_title(),
            ":cat_name"=>$this->getcat_name(),
            ":cat_desc"=>$this->getcat_desc(),
            ":cat_parent"=>$this->getcat_parent()
        ));
        Category::updateFile();
    }
    /**
     * Atualiza os dados de uma categoria
     * 
     */
    public function update(int $cat_id) {
        echo ($this->getcat_parent());        
        $sql = new Sql();
        $sql->query("UPDATE tb_categories set cat_title = :cat_title, cat_name = :cat_name, cat_desc = :cat_desc, cat_parent = :cat_parent WHERE cat_id = :cat_id;",array(
            ":cat_id"=>$cat_id,
            ":cat_title"=>$this->getcat_title(),
            ":cat_name"=>$this->getcat_name(),
            ":cat_desc"=>$this->getcat_desc(),
            ":cat_parent"=>$this->getcat_parent()
        ));
        Category::updateFile();
    }

    /**
     * Deleta (remove) uma categoria informando o id_cat.
     * 
     * @param int $id = id_cat da categoria que será excluida. 
     */
    public function deleteCatById($id){

        $sql = new \Blog\DB\Sql();
        $resultado = $sql->select("DELETE FROM tb_categories WHERE id_cat = :valor",array(
            ":valor"=>$id
        ));
        Category::updateFile();
        return true;
    }

    public static function updateFile()
    {
        $categories = Category::listAll();
        $html = [];

        foreach ($categories as $row) {
            array_push($html, '<li><a href="/category/'.$row["cat_name"].'">'.$row["cat_title"].'</a></li>');
        }

        file_put_contents($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."categories-menu.html", implode('', $html));
    }

    public function getPostsPage ($page = 1, $itensPerPage = 4)
    {

        $start = ($page -1)* $itensPerPage;
        $sql =  new Sql();
        $results = $sql->select("SELECT sql_calc_found_rows P.post_title, P.post_name, P.post_image, P.post_author, P.post_text, P.post_date, P.cat_id, C.cat_name, C.cat_title
            FROM tb_posts AS P 
            INNER JOIN tb_categories AS C ON P.cat_id = C.cat_id
            WHERE C.cat_name = :cat_name ORDER BY P.post_date DESC
            LIMIT $start, $itensPerPage;",array(
            ":cat_name"=>$this->getcat_name()    
        ));
        $resultTotal = $sql->select("SELECT FOUND_ROWS() as nrtotal;");

        return array(
            "data"=>$results,
            "total"=>(int)$resultTotal[0]["nrtotal"],
            "pages"=>ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        );
    }

}
