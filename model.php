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
			$cursor->sort(array('time' => 1));
			return $cursor;
		}
		
		public function updateNotice($id,$title,$text,$color){
			$collection = $this->connect->notes;
			$time=time();
			
			
			$mongoID = new MongoID($id);
			$userID=$collection->findOne(array('_id'=>$mongoID), array('id_autor'));
		$collection->update(['_id'=>$mongoID],['title'=>$title, 'text'=>$text, 'id_autor'=>$userID['id_autor'], 'color'=>$color ,'time'=>$time],array("upsert" => true));
			
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
				
			$_SESSION['login'] = $login;
			$password=md5($password);
			$_SESSION['password'] = $password;
		}
		
		public static function isLogin(){
			
			
			if(isset($_SESSION['login'])&&isset($_SESSION['password'])){
				
				$login=$_SESSION['login'];
				$password=$_SESSION['password'];
				
				$db=new DataBase;
				$testPass=$db->checkPassword($login);
				if($testPass==$password){
					return true;
					
				}
				else{
					session_unset();
					
					return false;
				}
			}
			else{
				session_unset();
				
				return false;
			}
		}
		
		public static function logOut(){

			
			session_unset();
						
		}
	}
	
	class Notes{
		public function createNote(){
			$login=$_SESSION['login'];
			$c="<form class='form-inline' id='newNote' action='' method='post'>";
			$c=$c."<div class='control-group'><label class='control-label' >Topic: </label><div class='controls'>";
			$c=$c."<input id='createTopic' name='title' type='text'>";
			$c=$c."</div></div><div class='control-group'><label class='control-label' >Text: </label><div class='controls'>";
			$c=$c."<textarea id='createText' name='text'></textarea>"; //"<input name='text' type='textarea'>";
			$c=$c."</div></div><div class='control-group'><label class='control-label' >Background color: </label><div class='controls'>";
			$c=$c."<input id='createColor' name='color' value='#00ffff' type='color'>";
			$c=$c."</div></div>";
			$c=$c."<input id='create' type='button' class='btn control-group' name='submit' value='Create' onclick=\"sendNote('$login')\">";			
			$c=$c."</form>";
			
			echo $c;
		}
		
		
		public function showNote($id,$title,$text,$color,$time){
			$c="<div class='note col-xs-3 col-xs-offset-1 col-xs-pull-1' id=\"$id\" style='background-color: ".$color."'>";
			$c=$c."<div class='btn-group '>";
			$c=$c."<button class='btn btn-default change' onclick='updateNote(\"$id\")'>Change</button>";
			$c=$c."<button class='btn btn-default' onclick='deleteNote(\"$id\")'>Delete</button></div><hr>";
			$c=$c."<div class='title'><b>$title</b></div><hr>";
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