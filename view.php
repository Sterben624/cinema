<?php include("includes/header.php"); ?>
<div id="login">
 <h1>Фільми у прокаті</h1>
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
	  <p class="regtext"><a href= "index.php">Увійти</a> щоб зробити замовлення</p>
 </form>
</div>
</div>

<?php include("includes/footer.php"); ?>