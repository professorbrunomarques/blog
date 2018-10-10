<?php 

namespace Blog\DB;

/**
 * Classe responsável por controlar o acesso ao banco de dados DAO
 * (DATA ACCESS OBJECT).
 *
 * @author Bruno Marques
 */
class Sql {

	// Constantes para conexao ao banco de dados
	const HOSTNAME = "127.0.0.1";
	const USERNAME = "root";
	const PASSWORD = "";
	const DBNAME = "aulasphp";

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME.";charset=UTF8", 
			Sql::USERNAME,
			Sql::PASSWORD
		);

	}
	
	/***********************************************************    
     *  Métodos publicos - serão usados por outras classes     *
    ***********************************************************/
	
	/**
     * Executa uma query SQL com a possibilidade de passar argumentos 
     * 
     * <b>Exemplo de uso:</b>
     * query("DELETE FROM tabela WHERE campo = :valor",array(
	 *	    ":valor"=>"valor"
     *	));
     * @param string $rawQuery = Query bruta sem tratamento que será tratada.
     * @param array $params = Array com os parametros a serem trocados por bindParam. 
     * 
     * @return PDOstatement Retorna um objeto do tipo PDOstatement após ser executado.
     */
    public function query($rawQuery, $params = array()) {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }

	/**
     * Executa uma consulta a uma tabela no banco de dados
     * 
     * <b>Exemplo de uso:</b>
     * query("DELETE FROM tabela WHERE campo = :valor",array(
	 *	     ":valor"=>"valor"
     * ));
     *
     * @param string $rawQuery = Query bruta sem tratamento que será tratada.
     * @param array $params = Array com os parametros a serem trocados por bindParam.
     * @return array Com o resultado da consulta.
     */
    public function select($rawQuery, $params = array()): array {
        $stmt = $this->query($rawQuery, $params);
        if ($stmt->errorInfo()[2] != NULL) {
            return $stmt->errorInfo();
        } else {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    /***********************************************************    
     *  Métodos privados - serão usados apenas nessa classe    *
    ***********************************************************/

    /**
     * Faz o bindParam dos dados
     * 
     * @param type $statement = Objeto do tipo PDOstatement criado pela função <b>query</b>.
     * @param type $parameters = Parametros que serão feitos os binds (ligações) com um valor.
     */

    private function setParams($statement, $parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    /**
     * Função auxiliar do metodo <b>setParams</b>
     * Executa o bindParam no objeto <b>$statement</b>
     * 
     * @param type $statement = Objeto do tipo PDOstatement criado pela função <b>query</b>.
     * @param type $campo = Nome do campo
     * @param type $valor = valor do campo
     */
    private function setParam($statement, $campo, $valor) {
        $statement->bindParam($campo, $valor);
    }

}

 ?>
