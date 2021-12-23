<?php include("includes/header.php"); ?>
<div id="login">
 <h1>Регістрація</h1>
<form action="register.php" id="registerform" method="post"name="registerform">
<p><label for="user_pass">Номер телефону<br>
<input class="input" id="phone" name="phone" size="32"type="phone" value=""></label></p>
<p><label for="user_pass">Ім'я користувача<br>
<input class="input" id="name" name="name"size="20" type="text" value=""></label></p>
<p><label for="user_pass">Пароль<br>
<input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
<p class="submit"><input class="button" id="register" name= "register" type="submit" value="Зарегіструватися"></p>
	  <p class="regtext">Вже зареєстровані? <a href= "index.php">Введіть ім'я користувача</a>!</p>
 </form>
</div>
</div>
<?php
	
	if(isset($_POST["register"])){
	
	if(!empty(($_POST['phone']) && !empty($_POST['name']) && !empty($_POST['password']))) {
	$phone=htmlspecialchars($_POST['phone']);
	$name=htmlspecialchars($_POST['name']);
	$password=htmlspecialchars($_POST['password']);
	$hash=md5($password);
	$query=mysqli_query($con,"SELECT * FROM user WHERE phone='".$phone."'");
	$numrows=mysqli_num_rows($query);
	if($numrows==0)
   {
	$sql="INSERT INTO user
  (phone, name, password)
	VALUES('$phone', '$name', '$hash')";
  $result=mysqli_query($con,$sql);
 if($result){
	$user_id_user=mysqli_query($con,"SELECT id_user FROM user WHERE phone='".$phone."'");
	while($row=mysqli_fetch_assoc($user_id_user))
 {
	$dblog=$row['id_user'];
 }
	echo $dblog;
	$sql2="INSERT INTO role_user
  (user_id_user, roles_id_roles)
	VALUES('$dblog', '1')";
	$result2=mysqli_query($con,$sql2);
	$message = "Account Successfully Created";
} else {
 $message = "Failed to insert data information!";
  }
	} else {
	$message = "That phone already exists! Please try another one!";
   }
	} else {
	$message = "All fields are required!";
	}
	}
	?>
	<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>

<?php include("includes/footer.php"); ?>