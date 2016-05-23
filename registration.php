<?php
	include_once 'model.php';
	if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
		$login=$_POST['login'];
		$password=$_POST['password'];
		$email=$_POST['email'];
		$dbReg=new DataBase();
		$userId=$dbReg->loginToId($login);
		
		if($userId==null){
			$dbReg->newUser($login,$password,$email);
			Login::startLogin($login,$password);
			
			echo "<script>  window.location = 'index.php'; </script>";
		}
		else{
			echo "<script>  alert('Пользователь с таким логином уже существует'); </script>";
			echo "<script>  window.location = 'registration.php'; </script>";
		}
	}
?>


<html>
<head>
	<title>Registration</title>
	<link href="main.css" rel="stylesheet">
	<link href="bootstrap-3.3.6-dist/css/bootstrap.css" rel="stylesheet">
	<script language="javascript" src="main.js"></script>
</head>
<body>
<p id="authorizationTitle">Registration</p>
<form id="authorization" action="" method="post" onsubmit="return checkForm()">

<p>Login: <input id="loginR" name="login" type="text" required></p>

<p>Password: <input id="passR" name="password" type="password" required></p>

<p>Confirm password: <input name="сonfPassword" type="password" required></p>

<p>E-mail: <input id="emailR" name="email" type="text" required></p>

<p><input class="btn btn-default logIn" type='submit' value='Registration'></p>

<a href="index.php">Authorization</a>

</form>
<p class="copyright">© 2016 Nikita Ryabovol</p>
</body>
</html>