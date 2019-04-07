<?php 
require_once('Class/Db.php');
require_once('Class/TableView.php');
$pdoStmt=$zend42Con->getCon()->prepare("SELECT * FROM chats WHERE sendBy=".$_GET['receiveByID']." OR receiveBy=".$_GET['receiveByID']." ORDER BY time ASC");
$pdoStmt->execute();
$all=$pdoStmt->fetchAll(PDO::FETCH_ASSOC);
?>