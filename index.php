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
	<link href="bootstrap-3.3.6-dist/css/bootstrap.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<script src="bootstrap-3.3.6-dist/js/bootstrap.js"></script>
	
</head>
<body>
<?php if (!$isSession): ?>
	<p id="authorizationTitle">Authorization</p>
	<form id="authorization" action="" method="post">
	<p>Login: <input id="loginInp" name="login" type="text"></p>
	<p>Password: <input name="password" type="password"></p>
	<p><input class="btn btn-default logIn" type='submit' value='LogIn'></p>
	<a href="registration.php">Registration</a>
	</form>
	<p class="copyright">© 2016 Nikita Ryabovol</p>
	
<?php else: ?>
<form action="" method="post">

	<p><input type='submit' class="btn btn-default" name="logOut" value='logOut'></p>

</form>
<p id="name">My Notes</p>
<div class="myBox container-fluid">
<div class="backgroundOfNotes">
<div class="row">

<?php 
	$login=$_SESSION['login'];
	$db=new DataBase();
	$userId=$db->loginToId($login);
	$cursor=$db->getNoticeByUser($userId);
	
	$newNote=new Notes();
	$newNote->showNotes($cursor);
?>
</div>
</div>
<?php	
	$newNote->createNote();
	
?>
</div>
<p class="copyright">© 2016 Nikita Ryabovol</p>
<?php endif; ?>

</body>
</html>