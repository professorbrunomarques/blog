<?php 

namespace Blog\Model;

use \Blog\Model;
use \Blog\helper\Check;
use \Blog\DB\Sql;

class User extends Model {

	const SESSION = "User";

	
	public static function login($login, $password):User
	{

		$db = new Sql();

		$results = $db->select("SELECT * FROM tb_users WHERE login = :LOGIN", array(
			":LOGIN"=>$login
		));

		if (count($results) === 0) {
			throw new \Exception("Não foi possível fazer login.");
		}

		$data = $results[0];

		if (password_verify($password, $data["password"])) {

			$user = new User();
			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();
           
			return $user;

		} else {

			throw new \Exception("Não foi possível fazer login.");

		}

	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;

	}

	public static function verifyLogin($inadmin = true)
	{
        
		if (
			!isset($_SESSION[User::SESSION])
			|| 
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["id_user"] > 0
			||
			(bool)$_SESSION[User::SESSION]["level"] !== $inadmin
		) {
			
			header("Location: /admin/login");
			exit;

		}

	}

	public static function listAll()
	{
		$sql = new Sql;
		return $sql->select("SELECT * FROM tb_users ORDER BY id_user ASC");
	}

	public static function save($data = array())
	{
		$data = array_map("strip_tags", $data);
		$data = array_map("trim", $data);
		$data["email"] = strtolower($data["email"]);
		$data["password"] = password_hash($data["password"],PASSWORD_DEFAULT,["code"=>12]);
		$data["level"] = (isset($data["level"])) ? 1 : 0;
		if(!Check::email($data["email"])){
			//throw new \Exception("O email informado é inválido! Retorne a página anterior");
			$data["error"] = true;
			return $data;
			exit;
		}
		$sql = new Sql;
		return $sql->query("INSERT INTO tb_users (id_user, login, password, name, level, email) VALUES (NULL, :login, :password, :name, :level, :email)", array(
			":login"=>$data["login"],
			":password"=>$data["password"],
			":name"=>$data["name"],
			":level"=>$data["level"],
			":email"=>$data["email"]
		));
	}

	public static function getUserById($id_user){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_users WHERE id_user = :id_user", array(
			":id_user"=>$id_user
		));
	}
	public static function deleteUserById($id_user){
		$sql = new Sql();
		return $sql->query("DELETE FROM tb_users WHERE id_user = :id_user", array(
			":id_user"=>$id_user
		));
	}

}

 ?>