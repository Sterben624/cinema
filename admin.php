<?php

session_start();

if(!isset($_SESSION["session_phone"])):
header("location:index.php");
else:
?>
	
<?php require_once("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin</title>
<link href="css/style.css" media="screen" rel="stylesheet">
<link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<div id="welcome">
<h2>Добро пожаловать, <span><?php echo $_SESSION['session_phone'];?> - Адмін! </span></h2>
  <p></p>
  <div> 
	<h2>Керування</h2>
	<ul>
		<li><a href="film.php">Фільми</a></li>
		<li><a href="sessionNew.php">Сеанси</a></li>
	</ul>
   </div>
     <p><a href="logout.php">Выйти</a> из системы</p>
</div>

<?php include("includes/footer.php"); ?>
	
<?php endif; ?>