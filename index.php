<?php include("includes/header.php"); ?>
<div id="login">
<h1>Вхід</h1>
<form action="" id="loginform" method="post"name="loginform">
<p><label for="user_login">Номер телефону<br>
<input class="input" id="phone" name="phone"size="20"
type="text" value=""></label></p>
<p><label for="user_pass">Пароль<br>
<input class="input" id="password" name="password"size="20"
type="password" value=""></label></p>
<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
<p class="regtext">Еще не зарегистрированы?<a href= "register.php">Регістрація</a>!</p>
</form>
</div>
</div>
<?php
	session_start();
	?>

	<?php require_once("includes/connection.php"); ?>
	<?php include("includes/header.php"); ?>	 
	<?php
	
	if(isset($_SESSION["session_phone"])){
	// вывод "Session is set"; // в целях проверки
	header("Location: intropage.php");
	header("Location: admin.php");
	}

	if(isset($_POST["login"])){

	if(!empty($_POST['phone']) && !empty($_POST['password'])) {
	$phone=$_POST['phone'];
	$password=($_POST['password']);
	//echo $phone;
	//echo $password;
	//echo md5($password);
	$query =mysqli_query($con, "SELECT * FROM user WHERE phone='".$phone."' AND password='".md5($password)."'");
	$sql=mysqli_query($con,"SELECT roles_id_roles FROM role_user WHERE user_id_user = (SELECT id_user FROM user WHERE phone=".$phone.")");

while($roww=mysqli_fetch_assoc($sql))
 {
	$dblog=$roww['roles_id_roles'];
 }
	$numrows=mysqli_num_rows($query);
	if($numrows!=0)
 {
	 echo $dblog;
while($row=mysqli_fetch_assoc($query))
 {
	$dbphone=$row['phone'];
	$dbpassword=$row['password'];
 }
  if($phone == $dbphone)
 {
	// старое место расположения
	//  session_start();
	 $_SESSION['session_phone']=$phone;	 
 /* Перенаправление браузера */
if($dblog=="1"){
   header("Location: intropage.php");
}
else if($dblog=="2"){
	header("Location: admin.php");
}
	}
	} else {
	//  $message = "Invalid username or password!";
	echo $dbpassword;
	echo  "Invalid phone or password!";
 }
	} else {
    $message = "All fields are required!";
	}
	}
	?>

<?php include("includes/footer.php"); ?>