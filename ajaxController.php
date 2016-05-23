
<script language="javascript" src="main.js"></script>
<?php 
include_once 'model.php';
ajax::catchNotePOST();
ajax::deleteNoteDB();
ajax::catchNoteUpdate();
class ajax{
	public static function catchNotePOST(){
		if(isset($_POST['title'])&&!empty($_POST['title'])&&empty($_POST['id'])&&!isset($_POST['update'])){
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
	
	public static function catchNoteUpdate(){
		if(isset($_POST['title'])&&!empty($_POST['title'])&&!empty($_POST['id'])&&isset($_POST['update'])){
			//echo 1;
				$title=$_POST['title'];
				$text=$_POST['text'];
				$color=$_POST['color'];
				$id=$_POST['id'];
			
			    //getR();
				$db=new DataBase();
				//$userId=$db->loginToId($login);
				 $db->updateNotice($id,$title,$text,$color);	
				
		}
	} 
	
	function cl_print_r ($var, $label = '')
{
	$str = json_encode(print_r ($var, true));
	echo "<script>console.group('".$label."');console.log('".$str."');console.groupEnd();</script>";
}
}
?>