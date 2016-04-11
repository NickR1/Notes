<?php
	class DataBase{
		private $db = 'myData';
		private $connect;
		function __construct(){
			$myClient = new MongoClient();
			$dbname = $this->db;
			$dataB = $myClient->$dbname;
			$this->connect=$dataB;
		}
		
		public function checkPassword($login){
			$collection = $this->connect->users;
			$pass=$collection->findOne(array('login'=>$login), array('password'));
			$pass = $pass["password"];
			return $pass;
		}
		
		public function checkUser($login,$password){
			$password=md5($password);
			$pass=$this->checkPassword($login);
			

			if($pass==$password){

				return true;
				
			}
			else{
				return false;
			}
		}
		
		public function newUser($login,$password,$email){
			$collection = $this->connect->users;
			$password=md5($password);
			$myArrUs = array(
           'login'     => $login,
           'password'   => $password,
           'email'  => $email
		   );
		   $collection->insert($myArrUs);
		}
		
		public function setNotice($title,$text,$userId,$color){
			$collection = $this->connect->notes;
			$time=time();
			$myNotes=array(
			'title'=>$title,
			'text'=>$text,
			'id_autor'=>$userId,
			'color'=>$color,
			'time'=>$time
			);
			$collection->insert($myNotes);
		}
		
		public function getNoticeByUser($userId){
			$collection = $this->connect->notes;
			$myUser=array('id_autor'=>$userId);
			$cursor = $collection->find($myUser);
			return $cursor;
		}
		
		public function updateNotice($id,$title,$text,$color){
			$collection = $this->connect->notes;
			$time=time();
			$add=array('$set'=>array( 'title'=>$title, 'text'=>$text, 'color'=>$color ,'time'=>$time));
			$collection->update(array('_id'=>$id),$add);
		}
		
		public function delNotice($id){
			$collection = $this->connect->notes;
			$collection->remove(array('_id'=>new MongoId($id)));

		}
		
		public function loginToId($login){
			$collection = $this->connect->users;
			$id=$collection->findOne(array('login'=>$login));
			$id=$id['_id'];
			return $id;
		}
	}
	
	class Login{
		public static function startLogin($login,$password){
			/*if(!isset($_SESSION)){
				//session_start(['cookie_lifetime' => 86400,]);
			}*/			
			$_SESSION['login'] = $login;
			$password=md5($password);
			$_SESSION['password'] = $password;
		}
		
		public static function isLogin(){
			
			//session_start();
			if(isset($_SESSION['login'])&&isset($_SESSION['password'])){
				//session_start();
				$login=$_SESSION['login'];
				$password=$_SESSION['password'];
				
				$db=new DataBase;
				$testPass=$db->checkPassword($login);
				if($testPass==$password){
					return true;
					
				}
				else{
					session_unset();
					//session_destroy();
					return false;
				}
			}
			else{
				session_unset();
				//session_destroy();
				return false;
			}
		}
		
		public static function logOut(){

			//session_start();
			session_unset();
			//session_destroy();			
		}
	}
	
	class Notes{
		public function createNote(){
			$login=$_SESSION['login'];
			$c="<form id='newNote' action='' method='post'>";
			$c=$c."<input name='title' type='text'>";
			$c=$c."<input name='text' type='textarea'>";
			$c=$c."<input name='color' type='color'>";
			$c=$c."<input type='button' name='submit' value='Create' onclick=\"sendNote('$login')\">";
			$c=$c."</form>";
			
			echo $c;
		}
		
		/*public function catchNotePOST(){
			if($_POST['title']=='3'){
				var_dump($_POST['title']);
			}
			if(isset($_POST['title'])&&!empty($_POST['title'])){//&&empty($_GET['new'])
				$title=$_POST['title'];
				$text=$_POST['text'];
				$color=$_POST['color'];
				$login=$_SESSION['login'];
				//$_POST['title']='';
				$db=new DataBase();
				$userId=$db->loginToId($login);
				$db->setNotice($title,$text,$userId,$color);
				//$_POST['tit']=1;
				//header("Location: index.php?new=1");
				
			}
		}*/
		
		public function showNote($id,$title,$text,$color,$time){
			$c="<div class='note' id=\"$id\" style='background-color: ".$color."'>";
			$c=$c."<button onclick='updateNote(\"$id\")'>Change</button>";
			$c=$c."<button onclick='deleteNote(\"$id\")'>Delete</button>";
			$c=$c."<div class='title'>$title</div>";
			$c=$c."<div class='text'>$text</div>";
			$c=$c."<div class='time'>$time</div>";
			$c=$c."</div>";
			echo $c;
		}
		
		public function showNotes($cursor){
			foreach($cursor as $value){
				$time=date('l jS \of F Y h:i:s A',$value['time']);
				$this->showNote($value['_id'],$value['title'],$value['text'],$value['color'],$time);
			}
		}
	}
?>