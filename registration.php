<?php 
	require_once('Class/Crud.php');
	function validate($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	$errors=array();
	$request=array();
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if(isset($_POST['name']) AND !empty($_POST['name'])){
			$request['name']=validate($_POST['name']);
		}else{
			$errors[]="Please Give Your Name";
		}
		if(isset($_POST['email']) AND !empty($_POST['email'])){
			filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)?$request['email']=$_POST['email']:$errors[]="Please Give A Valid Email.";
		}else{
			$errors[]="Please Give Your E-Mail";
		}
		if(isset($_POST['password']) AND isset($_POST['confirmPassword']) AND !empty($_POST['password'])){
			if($_POST['password']!=$_POST['confirmPassword']){
				$errors[]="Your Pssword Is Not Matched With Confirm Password.";
			}else{
				$request['password']=SHA1($_POST['confirmPassword']);
			}
		}else{
			$errors[]="Please Give Password And Confirm Password.";
		}
		if(empty($errors)){
			$crud=new Crud($zend42Con->getCon());
			echo $crud->insert('users', $request)?"Registration Successfull":"Registration Fail !!!";
			echo '<h2><a href="login.php">Login</a></h2>';
			exit;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
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
					<th>NAME</th>
					<td>:</td>
					<td><input type="text" name="name" value="<?php echo $_POST['name']??''; ?>"></td>
				</tr>
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
					<th>Confirm Password</th>
					<td>:</td>
					<td><input type="password" name="confirmPassword" value="<?php echo $_POST['confirmPassword']??''; ?>"></td>
				</tr>
				<tr>
					<td colspan="3"><center><input type="submit" value="REGISTER"></center></td>
				</tr>
			</table>
		</form>
	<h3><a href="index.php">HOME</a></h3>
</body>
</html>