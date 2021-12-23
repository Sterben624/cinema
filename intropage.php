<?php

session_start();

if(!isset($_SESSION["session_phone"])):
header("location:index.php");
else:
?>
<?php require_once("includes/connection.php"); ?>
<?php 
$id="";
$name="";
$price="";
$rating="";
$check="";
$bool="";
function getPosts(){
	$posts=array();
	$posts[0]=$_POST['id_ticket'];
	$posts[1]=$_POST['user_id_user'];
	$posts[2]=$_POST['session_id_session'];
	$posts[3]=$_POST['VIP'];
	$posts[4]=$_POST['place'];
	return $posts;
}
if (isset($_POST['add'])){
	$data=getPosts();
	//echo $data[1];
	//echo $data[2];
	//echo $data[3];
	//echo $data[4];
	if ( $_POST['VIP'] == ''){
		$check=0;
		}
		else {
        $check=1;
       }
	$bool=boolval($check);
	$insert_Query="INSERT INTO `tickets` (`user_id_user`, `session_id_session`, `VIP`, `place`) VALUES ('$data[1]', '$data[2]', '$bool', '$data[4]')";
	try{
		$insert_Result=mysqli_query($con, $insert_Query);
		if($insert_Result){
			if(mysqli_affected_rows($con)>0){
				echo 'Data insered';
			}else{
				echo 'Data Not insered';
			}
		}
	}catch(Exception $ex){
		echo 'Error insert' .$ex->getMessage();
	}
}
?>
<?php include("includes/header.php"); ?>
<div id="login">
<h2 align='center'>Добро пожаловать, <span><?php echo $_SESSION['session_phone'];?>! </span></h2>
<h2 align="center">Фільми в прокаті</h2>
<?php
$user_phone=$_SESSION['session_phone'];
$sql2=mysqli_query($con,"SELECT id_user FROM user WHERE phone='$user_phone'");
while($roww=mysqli_fetch_assoc($sql2))
 {
	$user_id_user=$roww['id_user'];
 }
$sql = "SELECT * FROM film";
if($result = $con->query($sql)){
    echo "<table><tr bgcolor='#D3EDF6'><th>Id</th><th>Назва</th><th>Ціна</th><th>Рейтинг</th></tr>";
    foreach($result as $row){?>
        <tr>
           <?php
		    echo "<td align='center'><a>" . $row["id_film"] . "</a></td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td align='center'>" . $row["price"] . "</td>";
			echo "<td align='center'>" . $row["rating"] . "</td>";?>
        </tr>
   <?php }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}?>
<h2 align='center'>Сеанси зараз</h2>
<?php
$sql2 = "SELECT * FROM session ORDER BY time";
if($result2 = $con->query($sql2)){
    echo "<table align='center'><tr bgcolor='#D3EDF6'><th>Id</th><th>Id Film</th><th>Зала</th><th>Дата</th></tr>";
    foreach($result2 as $row){
			$sql=mysqli_query($con, "SELECT name FROM film WHERE id_film='". $row["film_id_film"] ."'");
			while($roww=mysqli_fetch_assoc($sql)){
			$film_name=$roww['name'];
			}?>
        <tr>
           <?php
		    echo "<td align='center'><a>" . $row["id_session"] . "</a></td>";
            echo "<td align='center'>" . $film_name . "</td>";
            echo "<td align='center'>" . $row["hall_id_hall"] . "</td>";
			echo "<td align='center'>" . $row["time"] . "</td>";?>
        </tr>
   <?php }
    echo "</table>";
    $result2->free();
} else{
    echo "Ошибка: " . $conn->error;
}
?>
  <h2 align='center'>Зробити вибір:</h2>
<form action="" id="loginform" method="post"name="loginform">
<p align='center'><label for="user_pass">Номер сесії<br>
<?php
$sql = "SELECT * FROM session";
$result_select = mysqli_query($con,$sql);
/*Выпадающий список*/?>
<select class="input" name = 'session_id_session'>
<option> </option>
<?php
while($object = mysqli_fetch_object($result_select)){
echo "<option value = '$object->id_session' > $object->id_session </option>";
}
?></select></label>
</p>
<p align='center'><label for="user_pass">VIP: 1 - так, 0 - ні<br>
<input class="input" id="password" name="VIP"size="20"
type="checkbox" value="1"></label></p>
<p align='center'><label for="user_login">Місце<br>
<input class="input" id="phone" name="place"size="20"
type="number" value=""></label></p>
<p class="submit"><input class="button" name="add"type= "submit" value="Замовити"></p>
<p><a href="logout.php">Выйти</a> из системы</p>
</form>
</div>
</div>
	
<?php include("includes/footer.php"); ?>
	
<?php endif; ?>
