<?php 
	session_start();
	if(isset($_GET['chatReqUserId'])){
		$_SESSION['receiveByID']=$_GET['chatReqUserId'];
		header('Location: chatBox.php');
	}
?>