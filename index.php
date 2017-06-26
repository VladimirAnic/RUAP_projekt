<?php
	session_start();

		echo"<h1 class = 'text-center'>Klasifikacija znanja studenata</br></h1>";
	if(isset($_SESSION["ime"]))
	{
		if($_SESSION["ime"]!=null )
            {                
			    echo "<h4 class='text-right' align='center'>Dobrodošao {$_SESSION["ime"]}!</h4>";
            }	
	}
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
		.wrapper {	
            margin-top: 70px;
            margin-bottom: 70px;
			margin-left:160px;
			margin-right:160px;
			padding-top:20px;
			background-color:#fff;
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
                    <?php 
					if(isset($_SESSION["ime"]))
					{
						if($_SESSION["ime"]!=null )
							{
								echo "<li class='active'><a href='overview.php'>Pregled statistike </a></li>";
								echo "<li class='active'><a href='newTest.php'>Nova provjera razine znanja </a></li>";
								echo "<li class='active'><a href='signout.php'>Logout</a></li>";
								}
						}
						else 
						{
							echo "<li class='active'><a href='login.php'>Prijava </a></li>";
							echo "<li class='active'><a href='registration.php'>Registracija</a></li>";
							}
						?>

                </div>
            </div>
        </nav>
<div class="wrapper">
		<div class="container">

        	<div class="row">
            	<div class="col-md-8">
                <img class="img-responsive img-rounded" src="index_img.jpg" alt=""> <!--http://study.com/cimages/course-image/ftce-general-knowledge-test_117893_large.jpg-->
            	</div>

            <div class="col-md-4">
                <h1>Modeliranje znanja studenata</h1>
                <p>
					Modeliranje znanja je proces kreiranja modela znanja kojega će računalo moći interpretirati.
					Rudarenjem podataka moguće je doći do novih saznanja i potvrditi trenutna o znanju korisnika.
				</p>
				<p>
					Sam cilj modeliranja znanja u ovome kontekstu je klasificirati razinu znanja korisnika u jednu od 4 glavne skupine:
					<ul>
						<li>Very low - vrlo niska razina znanja</li>
						<li>Low - niska razina znanja</li>
						<li>Medium - srednja razina znanja</li>
						<li>High - visoka razina znanja</li>
					</ul>
				</p>
				<p>
					Znanje se određuje u ovisnosti o pet različitih atributa:
					<ul>
						<li>Stupnju vremena koje je provedeno učeći za ciljni predmet</li>
						<li>Stupnju broja ponavljanja za ciljni predmet</li>
						<li>Stupnju vremena koje je provedeno učeći za povezane predmete</li>
						<li>Uspješnosti na ispitu za povezani predmet</li>
						<li>Uspješnosti na ispitu za ciljni predmet</li>
					</ul>
				</p>
				<p>
					Testu mogu pristupiti polaznici od 6 (predškolski odgoj) do 110 godina nakon registracije.
					Korisnici web stranice imaju uvid u statistiku pojedinih unosa i samo izvoda, te ovisno o rezultatu mogu vidjeti i vizualizirano 
					broj postignutih rezultata za pojedinu od već navedenih kategorija.
				</p>
            </div>
     </div>
</div>
	</body>
</html>