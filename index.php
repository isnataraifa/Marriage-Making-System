<?php
require_once('Class/Db.php');
require_once('Class/TableView.php');
$table=new TableView($zend42Con->getCon());
    session_start();
if(!empty($_FILES)){
  if($fileName=$table->upload($_FILES)){
    $_POST['photo']=$fileName;
    echo $table->insert('profile', $_POST)?"Inserted":"Cannot Insert!";
  };
}
if(isset($_POST['login'])){
  $user=$table->selectWhere('profile',['email'=>$_POST['email'],'password'=>$_POST['password']]);
  if($user){
    $_SESSION['name']=$user[0]['first_name']." ".$user[0]['last_name'];
    $_SESSION['id']=$user[0]['id'];
    header("Location: index.php");
  }else{
    $loginError="Email Or Password Cannot Found!";
  }
}
/*// INSERT Table
echo $table->insert('students', ['name'=>'Anis', 'mobile'=>017, 'address'=>'Dhaka'])?"Inserted":"Cannot Insert!";*/

/*// UPDATE Table
echo $table->update('students', 2, ['name'=>'Habib'])?"Updated":"Cannot Update!";*/

/*// DELETE From Table
echo $table->delete('students', 2)?"Deleted":"Cannot Delete!";*/
?>
<!DOCTYPE html>
<html>
<?php require_once('head.php'); ?>
<body>
  <div class="container">
    <?php 
      if(isset($_SESSION['name'])){
        include('welcome.php');
      }else{
        ?>
        <div class="row centered-form">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Registration <small>It's free!</small></h3>
            </div>
            <div class="panel-body">
              <form role="form" enctype="multipart/form-data" method="post">
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
                </div>


                <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <input type="text" name="age" id="last_name" class="form-control input-sm" placeholder="Age">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <input type="text" name="address" id="last_name" class="form-control input-sm" placeholder="Address">
                  </div>
                </div>
                </div>

                <div class="form-group">
                  <label>Photo : </label>
                  <input id="male" type="radio" name="gender" value="1"> <label for="male">Male</label>
                  <input type="radio" name="gender" value="2" id="female"> <label for="female">Female</label>
                </div>
                <div class="form-group">
                  <label>Photo : </label>
                  <input type="file" name="photo" id="email" class="form-control input-sm" placeholder="Photo">
                </div>
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
                    </div>
                  </div>
                </div>
                
                <input type="submit" value="Register" class="btn btn-info btn-block">
              
              </form>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
          <div class="login-form">
            <form action="" method="post">
                <h2 class="text-center">Log in</h2>       
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
                <?php 
                  if(isset($loginError)){
                    echo "<p style='color:red;'>".$loginError."</p>";
                  }
                 ?>
                <div class="form-group">
                  <input type="submit" name="login" value="LogIn" class="btn btn-info btn-block">
                </div>
              </form>
        </div>
        </div>
      </div>  
        <?php
      }
     ?>
        
    </div>


  <!-----------Featured Profiles Section---->
  <section class="module content feature_pro" id="app-promo">
    <div class="home-wrapper feature_part">
      <h2>Featured Profiles</h2>
      
  <ul id="myTab" class="nav nav-tabs">
       <li class="active">
        <a href="#home" data-toggle="tab" aria-expanded="true">
         Brides
        </a>
       </li>
   
   <li class="">
    <a href="#ios" data-toggle="tab" aria-expanded="false">Grooms</a></li>
   </ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="home">
        <ul>

          <?php 
            $male=$table->selectWhere('profile',['gender'=>'1']);
            $female=$table->selectWhere('profile',['gender'=>'2']);
           ?>
              <?php 
                while($row=current($female)){
                  if(isset($_SESSION['id'])){
                    if($_SESSION['id']==$row['id']){
                        next($female);
                        continue;
                    }
                  }
                  ?>
            <li>
                  <div class="lft_cnt">
                      <a onclick="javascript: <?php if(!isset($_SESSION['id'])) echo 'alert(\'Please Login First.\');return false;'; ?>" href="profile.php?id=<?php echo $row['id']; ?>"><img src="asset/images/<?php echo $row['photo'] ?>"></a>
                  </div>
                  <div class="rgt_cnt">
                    <span class="usr_name"><?php echo $row['first_name']." ".$row['last_name']; ?></span>
                    <span class="usr_id">(ID:<?php echo $row['id']; ?>)</span>
                    <span class="usr_det disblk"><?php echo $row['address']; ?></span>
                    <span class="usr_det disblk">Age: <?php echo $row['age']; ?></span>
                    <span class="disblk"><?php echo $row['email']; ?></span></div>
            </li>
                  <?php
                  next($female);
                }
              ?>
        </ul>
    </div>
    <div class="tab-pane fade" id="ios">
        <ul>
              <?php 
                while($row=current($male)){
                  ?>
            <li>
                  <div class="lft_cnt">
                      <a href="profile.php?id=<?php echo $row['id']; ?>"><img src="asset/images/<?php echo $row['photo'] ?>"></a>
                  </div>
                  <div class="rgt_cnt">
                    <span class="usr_name"><?php echo $row['first_name']." ".$row['last_name']; ?></span>
                    <span class="usr_id">(ID:<?php echo $row['id'] ?>)</span>
                    <span class="usr_det disblk"><?php echo $row['address']; ?></span>
                    <span class="usr_det disblk">Age: <?php echo $row['age']; ?></span>
                    <span class="disblk"><?php echo $row['email']; ?></span></div>
            </li>
                  <?php
                  next($male);
                }
              ?>
        </ul>
    </div>
</div>
  </div></section>
</body>
</html>