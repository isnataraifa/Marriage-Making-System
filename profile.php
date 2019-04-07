<?php
require_once('Class/Db.php');
require_once('Class/TableView.php');
$table=new TableView($zend42Con->getCon());
session_start();
    if(!isset($_SESSION['name'])){
      header('Location: index.php');
    }
  if(isset($_GET['liked'])){
    if($table->insert("likes",["likedBy"=>$_SESSION['id'], 'liked'=>$_GET['liked']])){
      header("Location: profile.php?id=".$_GET['liked']);
      exit;
    }
  }
if(isset($_GET['id'])){
  $id=(int)$_GET['id'];
}else{
  header('Location: index.php');
}
$profile=$table->selectWhere("profile",["id"=>$id])[0];
if(!$profile){
  header('Location: index.php?');
}

?>
<!DOCTYPE html>
<html>
<?php require_once('head.php'); ?>
<style type="text/css">
  th, td{
    /*border: 1px solid #000;*/
    padding: 5px;
  }
</style>
<body>
  <?php 
      include('welcome.php');
  ?>
  <center>
    <table border="1">
      <tr>
        <td colspan="4"><center><img style="width: 200px; height: 200px;border-radius: 139px;" src="asset/images/<?php echo $profile['photo']; ?>"></center></td>
      </tr>
      <tr>
        <th>First Name</th>
        <td>:</td>
        <td><?php echo $profile['first_name']; ?></td>
      </tr>
      <tr>
        <th>Last Name</th>
        <td>:</td>
        <td><?php echo $profile['last_name']; ?></td>
      </tr>
      <tr>
        <th>Age</th>
        <td>:</td>
        <td><?php echo $profile['age']; ?></td>
      </tr>
      <tr>
        <th>Address</th>
        <td>:</td>
        <td><?php echo $profile['address']; ?></td>
      </tr>
      <tr>
        <th>E-Mail</th>
        <td>:</td>
        <td><?php echo $profile['email']; ?></td>
      </tr>
      <?php 
        if($table->selectWhere('likes', ['likedBy'=>$_SESSION['id'], 'liked'=>$id])){
          if($table->selectWhere('likes', ['likedBy'=>$id, 'liked'=>$_SESSION['id']])){
            ?>
            <tr>
              <th colspan="3"><center><a href="chatRoute.php?chatReqUserId=<?php echo $id; ?>"><img style="width: 180px;cursor: pointer;" src="asset/images/chatButton.png"></a></center></th>
            </tr>
            <?php
          }else{
            ?>
            <tr>
              <th colspan="3"><center>You already liked <?php echo $profile['first_name']." ".$profile['last_name']; ?>. <br> <small>You can chat with each other if <?php echo $profile['first_name']." ".$profile['last_name']; ?> also likes your profile. </small></center></th>
            </tr>
            <?php
          }
        }else{
          ?>
          <tr>
            <th colspan="3" style="text-transform: uppercase;">If You Want To Chat With <?php echo $profile['first_name']; ?> Then Hit The Like Button.</th>
          </tr>
          <tr>
            <th colspan="3"><center><a href="profile.php?liked=<?php echo $profile['id']; ?>"><img style="width: 100px;cursor: pointer;" src="asset/images/loveButton.png"></a></center></th>
          </tr>
          <?php
        }
      ?>
    </table>
  </center>
</body>
</html>