<?php
	include_once 'model.php';
	if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
		$login=$_POST['login'];
		$password=$_POST['password'];
		$email=$_POST['email'];
		$dbReg=new DataBase();
		$dbReg->newUser($login,$password,$email);
		Login::startLogin($login,$password);
		//header("Location: index.php");
		echo "<script>  window.location = 'index.php'; </script>";
	}
?>


<html>
<head>
<title>Registration</title>

</head>
<body>
<form action="" method="post">

<p>Login: <input name="login" type="text"></p>

<p>Password: <input name="password" type="text"></p>

<p>Confirm password: <input name="сonfPassword" type="text"></p>

<p>E-mail: <input name="email" type="text"></p>

<p><input type='submit' value='Registration'></p>

</form>
</body>
</html>