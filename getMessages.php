<?php 
require_once('Class/Db.php');
require_once('Class/TableView.php');
$table=new TableView($zend42Con->getCon());
session_start();
if(!isset($_SESSION['name'])){
      header('Location: index.php');
    }
 if(isset($_GET['receiveByID'])){
 	if(isset($_GET['sendBy']) AND isset($_GET['receiveByID']) AND isset($_GET['message']) AND !empty($_GET['message'])){
 	$table->insert('chats', ['sendBy'=>$_GET['sendBy'], 'receiveBy'=>$_GET['receiveByID'], 'time'=>time(), 'message'=>$_GET['message']]);
 }
 	$pdoStmt=$zend42Con->getCon()->prepare("SELECT * FROM chats WHERE (sendBy=".$_GET['sendBy']." AND receiveBy=".$_GET['receiveByID'].") OR (sendBy=".$_GET['receiveByID']." AND receiveBy=".$_GET['sendBy'].") ORDER BY time DESC");
	$pdoStmt->execute();
	$all=$pdoStmt->fetchAll(PDO::FETCH_ASSOC);

print_r($all);
 	while($row=current($all)){
 		?>
 		<tr>
	        <td class="<?php if($_SESSION['id']!=$row['sendBy']) echo 'sender'; ?>" colspan="2"><span class="<?php if($_SESSION['id']==$row['sendBy']) echo 'me'; ?>"><?php echo $row['message']; ?></span></td>
	      </tr>
 		<?php
 		next($all);
 	}
 	
 }
?>