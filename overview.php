<?php
	session_start();
	if($_SESSION["ime"]!=null )
			echo "<h1>Dobrodošao/la {$_SESSION["ime"]} {$_SESSION["prezime"]}!\n</h1>";
    else header("Location:login.php");
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
		<h1>Pregled prijašnjih podataka</h1>
       <button type="button" onclick="location.href = 'newTest.php';">Nova provjera razine znanja</button> 
<?php
include 'connection.php';
echo '<table class="table" width="60%" border="1px" cellpadding="2" cellspacing="2">';
		echo '<tr><td><b>Vrijeme učenja za predmet</b></td>';
		echo '<td><b>Broj ponavljanja za predmet</b></td>';
		echo '<td><b>Vrijeme učenja za povezane predmete</b></td>';
		echo '<td><b>Uspješnost na ispitu za predmet</b></td>';
        echo '<td><b>Uspješnost na ispitu za povezane predmete</b></td>';
		echo '<td><b>Razina znanja</b></td></tr>';
		$sql = "SELECT * FROM `entries`,`user` WHERE user_ID='{$_SESSION["ID"]}' AND user_ID=user.ID ;";
		try {
		   $mid =$conn->prepare($sql);
		   $mid->execute();
		   $result=$mid->fetchAll();
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
		if ($mid->rowCount() > 0) {
			 foreach($result as $row) {
				echo '<tr><td>'.$row["STG"].'</td>';
				echo '<td>'.$row["RGO"].'</td>';
				echo '<td>'.$row["STRO"].'</td>';
				echo '<td>'.$row["EPRO"].'</td>';
                echo '<td>'.$row["EPG"].'</td>';
				echo '<td>'.$row["knowledge_level"].'</td></tr>';
			 }
			 echo '</table>';
		} 
		else echo "<br/>Nema rezultata<br/>";
       
?>
    <a href='signout.php'>Odjava</a>
    </body>
</html>
