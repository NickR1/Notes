<?php
	include_once 'model.php';
	if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
		$login=$_POST['login'];
		$password=$_POST['password'];
		$email=$_POST['email'];
		$dbReg=new DataBase();
		$dbReg->newUser($login,$password,$email);
		
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

<p>E-mail: <input name="email" type="text"></p>

<p><input type='submit' value='Отправить'></p>

</form>
</body>
</html>