<?php
require_once('Class/Db.php');
require_once('Class/TableView.php');
$table=new TableView($zend42Con->getCon());
session_start();
if(!isset($_SESSION['name'])){
      header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
<?php require_once('head.php'); ?>
<style type="text/css">
  .me,.sender span{
  background-color: aquamarine;
    padding: 5px 10px;
    border-radius: 10px;
  }
  .sender{
    text-align: right;
  }
  .me{
  background-color: #ffa0a0; 
  }
  .msgDiv{
        height: 300px;
    overflow-x: auto;
    width: 50%;
  }
  table{
    width: 100%;
  }
  table, th, td{
    border: 1px solid #000;
    padding: 10px 10px;
  }
</style>
<body>
  <?php 
      include('welcome.php');
  ?>
  <center>
  <div class="msgDiv">
    <table border="1">
      <?php 
        $name=$table->selectWhere('profile', ['id'=>$_SESSION['receiveByID']]);
      ?>
      <caption><center>You Are Chating With <?php echo $name[0]['first_name']." ".$name[0]['last_name'] ?></center></caption>
      
      <tbody id="allChat">
        
      </tbody>
    </table>
  </div>
  <table style="width: 50%;">
      <tfoot>
      <tr>
        <td style="padding: 0px;">
          <form id="chatForm" method="post">
            <input id="message" style="width: 70%; height: 40px;" type="text" name="message">
            <input style="width: 29%; height: 40px;background-color: mediumspringgreen;" type="submit" value="SEND">
          </form></td>
      </tr>
      </tfoot>
  </table>
  </center>
<script type="text/javascript">
  setInterval(function(){ 
    $.ajax({url: "getMessages.php?sendBy=<?php echo $_SESSION['id'] ?>&receiveByID=<?php echo $_SESSION['receiveByID']; ?>", success: function(result){
        $('#allChat').html(result);
    }});

   }, 2000);

  $('.msgDiv').animate({
        scrollTop: $('.msgDiv').scrollHeight}, 0);

  $("#chatForm").submit(function(){
    $.ajax({url: "getMessages.php?sendBy=<?php echo $_SESSION['id'] ?>&receiveByID=<?php echo $_SESSION['receiveByID']; ?>&message="+$("#message").val(), success: function(result){
        $('#allChat').html(result);
    }});
    $("#message").val('');
    return false;
  });
</script>
</body>
</html>