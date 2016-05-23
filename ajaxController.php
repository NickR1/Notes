

<?php 
include_once 'model.php';
ajax::catchNotePOST();
ajax::deleteNoteDB();
class ajax{
	public static function catchNotePOST(){
		if(isset($_POST['title'])&&!empty($_POST['title'])){
				$title=$_POST['title'];
				$text=$_POST['text'];
				$color=$_POST['color'];
				$login=$_POST['login'];
			
				
				$db=new DataBase();
				$userId=$db->loginToId($login);
				$db->setNotice($title,$text,$userId,$color);
				
				
		}
	}
	
	public static function deleteNoteDB(){
		if(isset($_POST['delete'])&&!empty($_POST['delete'])){
				$id=$_POST['delete'];
				$db=new DataBase();
				$db->delNotice($id);
		}
	}
}
?>