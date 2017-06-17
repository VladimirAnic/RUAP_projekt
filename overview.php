<?php
	session_start();
	if($_SESSION["ime"]!=null )
	{
		echo '<div>';
		echo"<h1 class = 'text-center'>Pregled vaših dosadašnjih rezultata</h1>";
		echo "<h4 class='text-right' align='center'>Dobrodošao {$_SESSION["ime"]}!</h4>";
		echo '</div>';
		}
    else header("Location:login.php");
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
		<style>

        body{
            background-color:#eee;
        }
			
			</style>
    </head>
    <body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="newTest.php">Nova provjera razine znanja</a></li>
				<li class="active"><a href="signout.php">Logout</a></li>
			</div>
		</div>
	</nav>
	<div class="container col-md-4">
		<h3>Pregled prijašnjih podataka: </h3>
		</div>
		<div class="container col-md-9"></div>
	<form>
	<input type="submit" name="export" id="export"value="export"/>
	</form>
<?php
include 'connection.php';
echo '<div class="container col-md-6">';
echo '<table class="table" border="1px">';
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
			 echo '</div>';
			 echo '<div class = "container col-md-8"/>';

		} 
		else echo "<br/>Nema rezultata<br/>";

		echo '<div class = "container col-md-6">';
		//echo "<input type='submit' name = 'export' value='Export' method='POST'/>";
		echo '</div>';
		echo '<div class = "container col-md-6"/>';

		if(isset($_POST["export"])){//trial for file export
			$sqlExport = "SELECT * FROM `entries`,`user` WHERE user_ID='{$_SESSION["ID"]}' AND user_ID=user.ID INTO OUTFILE '/mytable.csv' ;";
		try {
		   $mid =$conn->prepare($sqlExport);
		   $mid->execute();
		   $result=$mid->fetchAll();
		}
		catch(PDOException $e)
		{
			echo $sqlExport . "<br>" . $e->getMessage();
		}
		}

/*	datavis for later
		//http://www.d3noob.org/2013/02/using-mysql-database-as-source-of-data.html
		if(isset($_POST["export"])) 
		{
			$myquery ="SELECT 'EPG','knowledge_level' FROM `entries`,`user` WHERE user_ID='{$_SESSION["ID"]}' AND user_ID=user.ID ;";;
    	$query = mysql_query($myquery);
    
    	if ( ! $query ) 
		{
			echo mysql_error();
			die;
		}
    
    $data = array();
    
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
        $data[] = mysql_fetch_assoc($query);
    }
    
    echo json_encode($data);


	}*/
       
?>
	</body>
</html>
