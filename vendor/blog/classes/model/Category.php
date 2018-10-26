<?php

namespace Blog\model;

use \Blog\DB\Sql;
use \Blog\Model;

class Category extends Model {
    
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
    public static function getCatByName(string $valor){
        $sql = new \Blog\DB\Sql();
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
        
    }
    /**
     * Atualiza os dados de uma categoria
     * 
     */
    public function update(int $cat_id) {
                
        $sql = new Sql();
        $sql->query("UPDATE tb_categories set cat_id = :cat_id, cat_title = :cat_title, cat_name = :cat_name, cat_desc = :cat_desc, cat_parent = :cat_parent WHERE cat_id = :cat_id;",array(
            ":cat_id"=>$cat_id,
            ":cat_title"=>$this->getcat_title(),
            ":cat_name"=>$this->getcat_name(),
            ":cat_desc"=>$this->getcat_desc(),
            ":cat_parent"=>$this->getcat_parent()
        ));
        
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
        return true;
    }





}
