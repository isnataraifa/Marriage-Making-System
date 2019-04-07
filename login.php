<?php
	require_once('Class/Crud.php');
	$errors=array();
	$request=array();
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if(isset($_POST['email']) AND !empty($_POST['email'])){
			filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)?$request['email']=$_POST['email']:$errors[]="Please Give A Valid Email.";
		}else{
			$errors[]="Please Give Your E-Mail";
		}
		if(isset($_POST['password']) AND !empty($_POST['password'])){
			$request['password']=SHA1($_POST['password']);
		}else{
			$errors[]="Please Give A Password.";
		}
		if(empty($errors)){
			$crud=new Crud($zend42Con->getCon());
			if(count($user=$crud->selectWhere('users', $request))==1){
				$crud=new Crud($zend42Con->getCon());
					if($crud->update('users', $user[0]['id'], ['lastLogin'=>date("d-m-Y h:i:s", getDate()[0])])){
						session_start();
						$_SESSION['user']=$user[0];
						$_SESSION['loginTime']= getDate();
						header("Location: welcome.php");
						exit;
					}else{
						$errors[]="Something Wrong! Please Try Again.";
					}
			}else{
				$errors[]="Email or Password not found !";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css">
		th{
			text-align: right;
		}
		.error{
			color: red;
		}
	</style>
</head>
<body>
	<?php 
		if(!empty($errors)){
			foreach($errors AS $err) {
				echo "<p class='error'>--".$err."</p>";
			}
		}
	 ?>
		<form method="post" action="">
			<table>
				<tr>
					<th>E-Mail</th>
					<td>:</td>
					<td><input type="mail" name="email" value="<?php echo $_POST['email']??''; ?>"></td>
				</tr>
				<tr>
					<th>Password</th>
					<td>:</td>
					<td><input type="password" name="password" value="<?php echo $_POST['password']??''; ?>"></td>
				</tr>
				<tr>
					<td colspan="3"><center><input type="submit" value="LOGIN"></center></td>
				</tr>
			</table>
		</form>
		<h2><a href="index.php">Home</a></h2>
</body>
</html>