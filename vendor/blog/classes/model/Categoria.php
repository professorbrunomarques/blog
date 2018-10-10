<?php

namespace Blog\model;

class Categoria {
    
    private $cat_id;
    private $cat_titulo;
    private $cat_name;
    private $cat_parent;

    /**
     * Retorna um array com todos os dados da tabela categorias.
     * 
     * @return array com todas as categorias.
     */
    public function getAllCat(){
        $sql = new \Blog\DB\Sql();
        $resultado = $sql->select("SELECT * FROM categorias");
        if(count($resultado)>0){
            return $resultado;
        }else{
            return "Nenhum registro encontrado.";
        }
    }
    /**
     * Retorna uma categoria informando o id_cat
     * 
     * @param int $id Informe o id da categoria a ser consultada
     * @return array com o resultado da consulta.
     */
    public function getById(int $id){
        $sql = new \Blog\DB\Sql();
        $resultado = $sql->select("SELECT * FROM categorias WHERE id_cat = :id",array(
            ":id"=>$id
        ));
        if(count($resultado)>0){
            return $resultado;
        }else{
            return "Nenhum registro encontrado.";
        }
    }
    /**
     * Retorna uma categoria informando o cat_name (nome da categoria em formato URL).
     * 
     * @param int $valor Informe o cat_name da categoria a ser consultada
     * @return array com o resultado da consulta.
     */
    public function getCatByName(string $valor){
        $sql = new \Blog\DB\Sql();
        $resultado = $sql->select("SELECT * FROM categorias WHERE cat_name = :valor",array(
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
        $sql->query("INSERT INTO categorias (id_cat, cat_titulo, cat_name, cat_parent) VALUES (NULL, :cat_titulo, :cat_name, :cat_parent)", array(
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
        $resultado = $sql->select("DELETE FROM categorias WHERE id_cat = :valor",array(
            ":valor"=>$id
        ));
        return true;
    }




//  GETS AND SETTER    
    function getCat_id() {
        return $this->cat_id;
    }

    function getCat_titulo() {
        return $this->cat_titulo;
    }

    function getCat_name() {
        return $this->cat_name;
    }

    function getCat_parent() {
        return $this->cat_parent;
    }

    private function setCat_id($cat_id) {
        $this->cat_id = $cat_id;
    }

    private function setCat_titulo($cat_titulo) {
        $this->cat_titulo = $cat_titulo;
    }

    private function setCat_name($cat_name) {
        $this->cat_name = $cat_name;
    }

    private function setCat_parent($cat_parent) {
        $this->cat_parent = $cat_parent;
    }

}
