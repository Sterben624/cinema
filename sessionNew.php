<?php require_once("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Session</title>
<link href="css/style.css" media="screen" rel="stylesheet">
<link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head> 
<body>
<div class="container mlogin">
<?php 
$id="";
$film_id="";
$hall_id="";
$time="";
function getPosts(){
	$posts=array();
	$posts[0]=$_POST['id'];
	$posts[1]=$_POST['film_id_film'];
	$posts[2]=$_POST['hall_id_hall'];
	$posts[3]=$_POST['time'];
	return $posts;
}
if (isset($_POST['insert'])){
	$data=getPosts();
	$query=mysqli_query($con, "SELECT id_film FROM film WHERE name='".$data[1]."'");
	while($row=mysqli_fetch_assoc($query)){
	$dblog=$row['id_film'];
	}
	$insert_Query="INSERT INTO `session` (`film_id_film`, `hall_id_hall`, `time`) VALUES ('$dblog', '$data[2]', '$data[3]');";
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
if(isset($_POST['delete'])){
    $data = getPosts();
    $delete_Query = "DELETE FROM `session` WHERE `session`.`id_session` = $data[0]";
    try{
        $delete_Result = mysqli_query($con, $delete_Query);
        if($delete_Result){
           if(mysqli_affected_rows($con) > 0){
               echo 'Data Deleted';
           }else{
               echo 'Data Not Deleted';
           }
       }
    }catch (Exception $ex) {
       echo 'Error Delete '.$ex->getMessage();
    }
}
if(isset($_POST['update'])){
    $data = getPosts();
    $update_Query = "UPDATE `session` SET `film_id_film`='$data[1]',`hall_id_hall`='$data[2]',`time`='$data[3]' WHERE `session`.`id_session` = '$data[0]'";
    try{
        $update_Result = mysqli_query($con, $update_Query);
        if($update_Result){
            if(mysqli_affected_rows($con) > 0){
               echo 'Data Updated';
            }else{
               echo 'Data Not Updated';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Update '.$ex->getMessage();
    }
}
?>
<div id="login">
<h1>Сеанси</h1>
<p class="regtext"><a href= "admin.php">Завершити</a> роботу з сеансами</p>
<form action="" id="loginform" method="post"name="loginform">
<p><label for="user_login">Номер сесії<br>
<?php
$sql = "SELECT * FROM session";
$result_select = mysqli_query($con,$sql);
/*Выпадающий список*/?>
<select class="input" name = 'film_id_film'>
<option> </option>
<?php
while($object = mysqli_fetch_object($result_select)){
echo "<option value = '$object->id_session' > $object->id_session </option>";
}
?>
</select>
</p>
<p>
<label for="user_pass">Оберіть фільм<br>
<?php
$sql = "SELECT * FROM film";
$result_select = mysqli_query($con,$sql);
/*Выпадающий список*/?>
<select class="input" name = 'film_id_film'>
<option> </option>
<?php
while($object = mysqli_fetch_object($result_select)){
echo "<option value = '$object->name' > $object->name </option>";
}
?>
</select>
</p>
<p><label for="user_pass">Оберіть залу<br>
<?php
$sql = "SELECT * FROM hall";
$result_select = mysqli_query($con,$sql);
/*Выпадающий список*/?>
<select class="input" name = 'hall_id_hall'>
<option> </option>
<?php
while($object = mysqli_fetch_object($result_select)){
echo "<option value = '$object->id_hall' > $object->id_hall </option>";
}
?>
</select>
</p>
<p><label for="user_pass">Дата<br>
<input class="input" id="" name="time"size="20"
type="date" value="<?php echo $time ?>"></label></p>
<p class="submit">
<input class="button" type="submit" name="insert" value="Add">
<input class="button" type="submit" name="update" value="Update">
<input class="button" type="submit" name="delete" value="Delete">
</p>
</form>
<br>
<h2 align='center'>Сеанси зараз</h2>
<?php
$sql2 = "SELECT * FROM session";
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
</div>
</div>


