<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>	
        <link rel="stylesheet" href="css/style.css">
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
				<li class="active"><br/><a href='index.php'>Povratak na početnu stranicu</a></li>			
			</div>
		</div>
	</nav>
        <div class="wrapper"> <!--izvor za frontend postavljanje forme: https://codepen.io/ace-subido/pen/Cuiep -->
            <form class="form-signin" method="post">
                <h2 class="form-signin-heading">Prijavi se </br></br></h2>
                <label for="k_ime">Korisničko ime: </label>
                <input class="form-control" placeholder="Korisničko ime" type="text" name="k_ime" value="" id="k_ime"/>
                <br/><br/>
                <label for="lozinka">Lozinka: </label>
                <input class="form-control" placeholder="Lozinka" type="password" name="lozinka" value="" id="lozinka"/>
                <br/><br/>
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="salji" value="Pošalji"/>
                </br>
                <p>Niste još registrirani? <a href="registration.php">Registrirajte se ovdje!</a></p>
            
            <?php
            //provjera upisanih podataka u formi
            if(isset($_POST["salji"]) && $_POST["k_ime"]!=null && $_POST["lozinka"]!=null){
                $k_ime=$_POST["k_ime"];
                $lozinka=$_POST["lozinka"];
                include 'connection.php';
                $sql = "SELECT * FROM user WHERE user_name='{$k_ime}' AND pass='{$lozinka}';";//dohvaćanje svih korisnika sa unesenim korisničkim imenom i lozinkom
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
                    foreach($result as $row) {//dohvaćanje i postavljanje svih podataka u sjednicu za korisnika
                        $_SESSION["k_ime"]=$k_ime;
                        $_SESSION["ID"]=$row["ID"];
                        $_SESSION["email"]=$row["email"];
                        $_SESSION["ime"]=$row["name"];
                        $_SESSION["prezime"]=$row["surname"];
                        header("Location:overview.php");
                    }
                    
                } else {
                    $_SESSION["ime"]=null;
                    echo "<br/><p style='color:red'>Krivo korisničko ime ili lozinka. Pokušajte ponovo.</p>";
                }
            } 
        ?>

            </form>
        </div>
    </body>
</html>
