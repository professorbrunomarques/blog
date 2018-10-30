<?php 

namespace Blog\Model;

use \Blog\Model;
use \Blog\helper\Check;
use \Blog\DB\Sql;
use \Blog\Mailer;

class User extends Model {

	const SESSION = "User";
	const SECRET = "123qwe"; 
    const CIPHER = "AES-256-CBC";
	
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

	public function save($data = array())
	{	
		//Cria os metodos sets automaticamente
		$user = new User();
		$user->setData($data);

		$sql = new Sql;
		return $sql->query("INSERT INTO tb_users (id_user, login, password, name, level, email) VALUES (NULL, :login, :password, :name, :level, :email)", array(
			":login"=>$user->getlogin(),
			":password"=>$user->getpassword(),
			":name"=>$user->getname(),
			":level"=>$user->getlevel(),
			":email"=>$user->getemail()
		));
	}
	public function update($data = array(), int $id_user)
	{	
		//Cria os metodos sets automaticamente
		$user = new User();
		$user->setData($data);

		$sql = new Sql;
		return $sql->query("UPDATE tb_users set login = :login, name = :name, level = :level , email = :email WHERE id_user = :id_user", array(
			":login"=>$user->getlogin(),
			":name"=>$user->getname(),
			":level"=>$user->getlevel(),
			":email"=>$user->getemail(),
			":id_user"=>$id_user
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

	public static function getForgot(string $email){

		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_users WHERE email = :email", array(
			":email"=>$email 
		));
		if(count($result) === 0){
			throw new \Exception("Não foi possível recuperar sua senha");			
		}else{
			$data = $result[0];

			$results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :user_ip);", array(
				":iduser"=>$data["id_user"],
				":user_ip"=>$_SERVER["REMOTE_ADDR"]
			));

			if(count($results2) === 0){
				throw new \Exception("Não foi possível recuperar sua senha");
			}else{

				$dataRecovery = $results2[0];

				$IV = random_bytes(openssl_cipher_iv_length(User::CIPHER)); 
				//Codigo encriptografado
				$code = openssl_encrypt($dataRecovery["idrecovery"], User::CIPHER, USER::SECRET, 0, $IV);

				$result = base64_encode($IV.$code);
				
				$link = "http://localhost/admin/forgot/reset?code=$result";

				$mailer = new Mailer($data["email"], $data["name"], "Redefinir Senha do Blog", "forgot", array(
					"name"=> $data["name"],
					"link"=> $link
				));

				$mailer->send();

				return $data;
			}
		}
	}

	public static function validForgotDecrypt($result)
	{
		$result = base64_decode($result);
		$code = mb_substr($result, openssl_cipher_iv_length('aes-256-cbc'), null, '8bit');
		$iv = mb_substr($result, 0, openssl_cipher_iv_length('aes-256-cbc'), '8bit');
		$idrecovery = openssl_decrypt($code, 'aes-256-cbc', User::SECRET, 0, $iv);
		return $idrecovery;
	}

}

 ?>