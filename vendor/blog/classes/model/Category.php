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
     * @param array $dados Um array contendo os dados a serem inseridos na tabela (id_cat, cat_titulo, cat_name, cat_parent).
     * Observação o id_cat deve ser nulo ou "".
     * @return array com o resultado do insert.
     */
    public function insertCat($dados = array()):array {
        $this->cat_name = $dados["cat_name"];
        $this->cat_titulo = $dados["cat_titulo"];
        $this->cat_parent = $dados["cat_parent"];
        $sql = new \Blog\DB\Sql();
        $sql->query("INSERT INTO tb_categories (id_cat, cat_titulo, cat_name, cat_parent) VALUES (NULL, :cat_titulo, :cat_name, :cat_parent)", array(
            ":cat_name"=> $this->getCat_name(),
            ":cat_titulo"=> $this->getCat_titulo(),
            ":cat_parent"=> $this->getCat_parent()
        ));

        return $this->getCatByName($this->getCat_name);
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
