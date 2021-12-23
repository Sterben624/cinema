<?php require_once("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Film</title>
<link href="css/style.css" media="screen" rel="stylesheet">
<link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head> 
<body>
<div class="container mlogin">
<?php 
$id="";
$name="";
$price="";
$rating="";
function getPosts(){
	$posts=array();
	$posts[0]=$_POST['id'];
	$posts[1]=$_POST['name'];
	$posts[2]=$_POST['price'];
	$posts[3]=$_POST['rating'];
	$posts[4]=$_POST['namedel'];
	return $posts;
}
if(isset($_POST['search'])){
	$data=getPosts();
	$search_Query="SELECT * FROM film WHERE id_film=$data[0]";
	$search_Result=mysqli_query($con,$search_Query);
	if($search_Result){
		if(mysqli_num_rows($search_Result)){
			while($row=mysqli_fetch_array($search_Result)){
				$id=$row['id'];
				$name=$row['name'];
				$price=$row['price'];
				$rating=$row['rating'];
			}
		}else{
			echo 'No Data For This Id';
		}
	}else{
		echo 'Data Error';
	}
}
if (isset($_POST['insert'])){
	$data=getPosts();
	$insert_Query="INSERT INTO `film` (`name`, `price`, `rating`) VALUES ('$data[1]', '$data[2]', '$data[3]')";
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
	$query=mysqli_query($con, "SELECT id_film FROM film WHERE name='".$data[4]."'");
	while($row=mysqli_fetch_assoc($query)){
	$dblog=$row['id_film'];
	}
    $delete_Query = "DELETE FROM `film` WHERE `film`.`id_film` = $dblog";
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
    $update_Query = "UPDATE `film` SET `name`='$data[1]',`price`='$data[2]',`rating`=$data[3] WHERE `film`.`name` = '$data[4]'";
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
<h1>Фільми</h1>
<p class="regtext"><a href= "admin.php">Завершити</a> роботу з фільмами</p>
<form action="" id="loginform" method="post"name="loginform">
<p><label for="user_login">Виберіть фільм для видалення<br>
<?php
$sql = "SELECT * FROM film";
$result_select = mysqli_query($con,$sql);
/*Выпадающий список*/?>
<select class="input" name = "namedel">
<option> </option>
<?php
while($object = mysqli_fetch_object($result_select)){
echo "<option value = '$object->name' > $object->name </option>";
}
?></select>
</label>
</p>
<p><label for="user_pass">Назва<br>
<input class="input" id="password" name="name"size="20"
type="text" value="<?php echo $name ?>">
</label></p>
<p><label for="user_pass">Ціна<br>
<input class="input" id="password" name="price"size="20"
type="text" value="<?php echo $price ?>"></label></p>
<p><label for="user_pass">Рейтинг<br>
<input class="input" id="password" name="rating"size="20"
type="text" value="<?php echo $rating ?>"></label></p>
<p class="submit">
<input class="button" type="submit" name="insert" value="Add">
<input class="button" type="submit" name="update" value="Update">
<input class="button" type="submit" name="delete" value="Delete">
</p>
</form>
<br><br>
<?php
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
</div>
</div>


