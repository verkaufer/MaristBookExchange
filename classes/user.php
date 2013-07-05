<?php


///database table info is in wyncorporation
//under madlibs database

class User
{

	private $pdo;


	//use this like so:
	// $user = new User($db);
	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	public function login($username, $password){

		//gonna need to add some password encrypthing code here

		$password = md5($password);

		$login = $this->pdo->prepare("SELECT * FROM `users` WHERE username= :user AND password = :pass");
		$login->bindValue(':user', $username, PDO::PARAM_STR);
		$login->bindValue(':pass', $password, PDO::PARAM_STR);
		$login->execute();

		$result = $login->fetch(PDO::FETCH_ASSOC);

		if($result['password'] == $password && $result['username'] == $username){
			if($result['usergroup'] > 1)
			{
				$_SESSION['group'] = $result['usergroup'];
			}

			$_SESSION['uid'] = $result['id'];
			return TRUE;
		} else {
			return FALSE;
		}


	}

	public function register($user, $pass, $email){

		//select and see if user already exists
		$registerCheck = $this->pdo->prepare("SELECT COUNT(*) FROM `users` WHERE username = :user OR email = :email");
			$registerCheck->bindValue(':user', $user);
			$registerCheck->bindValue(':email', $email);
		$registerCheck->execute();

		if($registerCheck->fetchColumn() != 0){
			$_SESSION['REGISTER.ERROR'] = "A user already exists with this username or email address.";
			return FALSE;
		} else{

			$pass = md5($pass);//maybe add salt here?

			$register = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (:user, :pass, :email)");
				$register->bindValue(':user', $user, PDO::PARAM_STR);
				$register->bindValue(':pass', $pass, PDO::PARAM_STR);
				$register->bindValue(':email', $email, PDO::PARAM_STR);
			$register->execute();
			$_SESSION['FLASH.DATA'] = "Registration successful! Please login to begin using mBEx.";
			return TRUE;
		}

	}

	public function loggedIn(){
		if(isset($_SESSION['uid'])){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function isAdmin(){

		if(!isset($_SESSION['uid']) || !isset($_SESSION['usergroup'])){
			return FALSE;
		}
		else if ($_SESSION['usergroup'] != 2){
			return FALSE;
		} else {
			return TRUE;
		}

	}

	public function getUser($userID){

		$lookup = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
			$lookup->bindValue(':id', $userID);
		$lookup->execute();

		$userinfo = $lookup->fetch(PDO::FETCH_ASSOC);

		return $userinfo;

	}

	public function logout(){
		$_SESSION['uid'] = FALSE;
		$_SESSION['usergroup'] = FALSE;
		session_destroy();

		header("Location: index.php");

	}

// 	private function generateSalt($max = 15) {
//         $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
//         $i = 0;
//         $salt = "";
//         while ($i < $max) {
//             $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
//             $i++;
//         }
//         return $salt;
// }

}