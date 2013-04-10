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

		$login = $this->pdo->prepare("SELECT * FROM users WHERE username= :user");
		$login->bindValue(':user', $username, PDO::PARAM_STR);
		$login->execute();

		$result = $login->fetch(PDO::FETCH_ASSOC);

		$password = //do some kind of hashing here

		if($result['password'] == $password){
			
			$_SESSION['uid'] = $result['id'];
			return TRUE;
		}

		if($result['usergroup'] > 1)
		{
			$_SESSION['group'] = $result['usergroup'];
		}


	}

	public function register($user, $pass, $email){

		//select and see if user already exists
		$registerCheck = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :user OR email = :email");
			$registerCheck->bindValue(':user', $user);
			$registerCheck->bindValue(':email', $email);
		$registerCheck->execute();

		if($registerCheck->fetchColumn() != 0){
			return FALSE;
		}

		$register = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (:user, :pass, :email");
			$register->bindValue(':user', $user);
			$register->bindValue(':pass', $pass);
			$register->bindValue(':email', $email);
		$register->execute();

		return TRUE;

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

}