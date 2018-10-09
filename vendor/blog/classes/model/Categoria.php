<?php

namespace Blog\model;

class Categoria {
    
    private $cat_id;
    private $cat_titulo;
    private $cat_name;
    private $cat_parent;

    
    public function getAllCat(){
        $sql = new \Blog\DB\Sql();
        $resultado = $sql->select("SELECT * FROM categorias");
        if(count($resultado)>0){
            return $resultado;
        }else{
            return "Nenhum registro encontrado.";
        }
    }
    public function getById($id){
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
    public function insertCat($dados = array()) {
        $this->cat_name = $dados["cat_name"];
        $this->cat_titulo = $dados["cat_titulo"];
        $this->cat_parent = $dados["cat_parent"];
        $sql = new \Blog\DB\Sql();
        $sql->query("INSERT INTO categorias (id_cat, cat_titulo, cat_name, cat_parent) VALUES (NULL, :cat_titulo, :cat_name, :cat_parent)", array(
            ":cat_name"=> $this->getCat_name(),
            ":cat_titulo"=> $this->getCat_titulo(),
            ":cat_parent"=> $this->getCat_parent()
        ));
        return "A categoria ".$this->getCat_titulo(). " foi cadastrada com sucesso!";
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

    function setCat_id($cat_id) {
        $this->cat_id = $cat_id;
    }

    function setCat_titulo($cat_titulo) {
        $this->cat_titulo = $cat_titulo;
    }

    function setCat_name($cat_name) {
        $this->cat_name = $cat_name;
    }

    function setCat_parent($cat_parent) {
        $this->cat_parent = $cat_parent;
    }

}
