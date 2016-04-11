<?php 
	session_start(['cookie_lifetime' => 86400,]);
	include_once 'model.php';
	include_once 'ajaxController.php';
	if(isset($_POST['logOut'])){
		Login::logOut();
	}
	if(isset($_POST['login'])&&isset($_POST['password'])){
		$db=new DataBase();		
		$login=$_POST['login'];
		$password=$_POST['password'];
		$isUser=$db->checkUser($login,$password);
		if($isUser==true){
			Login::startLogin($login,$password);
		}
	}
	$isSession=Login::isLogin();
	
?>

<html>
<head>
	<title>Home</title>
	<script src="jquery-2.2.3.js"></script>
	<script language="javascript" src="main.js"></script>
	
</head>
<body>
<?php if (!$isSession): ?>

	<form action="" method="post">
	<p>Login: <input name="login" type="text"></p>
	<p>Password: <input name="password" type="password"></p>
	<p><input type='submit' value='LogIn'></p>
	<a href="registration.php">Registration</a>
	</form>
	
<?php else: ?>
<form action="" method="post">

	<p><input type='submit' name="logOut" value='logOut'></p>

</form>

<?php 
	$login=$_SESSION['login'];
	$userId=$db->loginToId($login);
	$cursor=$db->getNoticeByUser($userId);
	
	$newNote=new Notes();
	$newNote->showNotes($cursor);
	$newNote->createNote();
	//$newNote->catchNotePOST();
?>

<?php endif; ?>

</body>
</html>