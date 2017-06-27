<?php
	session_start();
	if($_SESSION["ime"]!=null )
	{
		echo '<div>';
		echo"<h1 class = 'text-center'>Pregled vaših dosadašnjih rezultata</h1>";
		echo "<h4 class='text-right' align='center'>Dobrodošao/la {$_SESSION["ime"]}!</h4>";
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
		<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
		<style>

        body{
            background-color:#eee;
        }
		.bar{
			fill: steelblue;
		}

		.bar:hover{
			fill: brown;
		}

			.axis {
			font: 10px sans-serif;
			}

			.axis path,
			.axis line {
			fill: none;
			stroke: #000;
			shape-rendering: crispEdges;
			}

	</style>
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
 
	<script src="http://d3js.org/d3.v3.min.js"></script>
    </head>
    <body>
		<script src="http://d3js.org/d3.v3.min.js"></script>
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
				<li class="active"><a href="index.php">Početna stranica </a></li>
				<li class="active"><a href="newTest.php">Nova provjera razine znanja</a></li>
				<li class="active"><a href="signout.php">Logout</a></li>
			</div>
		</div>
	</nav>
	<div class="container col-md-4">
		<h3>Pregled prijašnjih podataka: </h3>
		</div>
		<div class="container col-md-9"></div>

<?php
include 'connection.php';
//pravljenje tablice i dohvaćanje podataka iz baze za korisnika koji je ulogiran
echo '<div class="container col-md-8">';
echo '<table class="table" border="1px">';
		echo '<tr><td><b>Stupanj vremena koje je provedeno učeći za ciljni predmet</b></td>';
		echo '<td><b>Stupanj broja ponavljanja za ciljni predmet</b></td>';
		echo '<td><b>Stupanj vremena koje je provedeno učeći za povezane predmete</b></td>';
		echo '<td><b>Uspješnost na ispitu za povezani predmet</b></td>';
        echo '<td><b>Uspješnost na ispitu za ciljni predmet</b></td>';
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

		} 
		else{
			
				echo '<tr><td>'.'NaN'.'</td>';
				echo '<td>'.'NaN'.'</td>';
				echo '<td>'.'NaN'.'</td>';
				echo '<td>'.'NaN'.'</td>';
                echo '<td>'.'NaN'.'</td>';
				echo '<td>'.'NaN'.'</td></tr>';

			 echo '</table>';
			 echo '</div>';

		} 
		echo '<div id="chart_div" class = "container col-md-4 pull-right"></div>';

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
       
?>

	

   <?php include 'data.php'; ?>

   <script>
//vizualizacija podataka sa rezultatima ulogiranog korisnika
           function drawChart() {
                var data = new google.visualization.DataTable( <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?> );
                var chart = new google.visualization.ColumnChart(document.querySelector('#chart_div'));
                chart.draw(data, {
                    height: 400,
                    width: 600
                });
            }
            google.load('visualization', '1', {packages:['corechart'], callback: drawChart}); 
    </script>
	</body>
</html>
