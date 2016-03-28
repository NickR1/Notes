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
		
		public function checkLogin($login,$password){
			
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
		
		public function setNotice($title,$text){
			
		}
		
		public function getNoticeByUser($userId){
			
		}
		
		public function updateNotice($title,$password){
			
		}
	}
?>