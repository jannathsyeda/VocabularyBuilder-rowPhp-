<?php 
session_start();
include_once "config.php";
$status = 0;
$action = $_POST['action'] ?? "";
$connection      = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
mysqli_set_charset($connection, "utf8");
if(!$connection){
	throw new Exception("Not Connected");
}
else{
	if('register' == $action){
		$email = $_POST['email'] ?? "";
		$password = $_POST['password'] ?? "";
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING); 
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 
		if($email && $password){
			$hash = password_hash($password, PASSWORD_BCRYPT);
			$query = "INSERT INTO users(email,password) VALUES ('{$email}','{$hash}')";
			mysqli_query($connection,$query);
			if(mysqli_error($connection)){
				//echo mysqli_error($connection);
				$status = 1; //Duplicate Email Address
			}
			else{
				$status = 3; //User Created Successfully
			}
		}
		else{
			$status = 2;  //Email or Password Empty
		}
		header("Location: index.php?status={$status}");
	}
	else if('login' == $action){
		$username = $_POST['email'] ?? "";
		$password = $_POST['password'] ?? "";
		if($username && $password){
			$query = "SELECT id,password FROM users WHERE email='{$username}'";
			$result = mysqli_query($connection, $query);
			if(mysqli_num_rows($result) > 0){
				$data = mysqli_fetch_assoc($result);
				$_password = $data['password'];
				$_id = $data['id'];
				if(password_verify($password,$_password)){
					$_SESSION['id'] = $_id;
					header("Location: words.php");
					die();
				}
				else{
					$status = 4; //u & p did'n match
				}
			}else{
				$status = 5; //doesnt exist
			}
		}
		else{
			$status = 2;  //Email or Password Empty
		}
		header("Location: index.php?status={$status}");
	}
	elseif ('addword' == $action) {
		$word = $_REQUEST['word']?? '';
		$meaning = $_REQUEST['meaning']?? '';
		$word = filter_input(INPUT_POST, 'word', FILTER_SANITIZE_STRING); 
		$meaning = filter_input(INPUT_POST, 'meaning', FILTER_SANITIZE_STRING); 
		$user_id = $_SESSION['id'] ?? '';
		if($word && $meaning && $user_id){
			$query =  "INSERT INTO words (user_id,word,meaning) VALUES ('{$user_id}','{$word}','{$meaning}')";
			mysqli_query($connection,$query);
		}
		header("Location: words.php");
	}

	

}

?>
