<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
		<link rel="stylesheet" href="css/style.css">
		<script>
			function checkname()	//http://talkerscode.com/webtricks/check%20username%20and%20email%20availability%20from%20database%20using%20ajax.php
				{//dinamička provjera korisničkog imena iz baze
						var k_ime=document.getElementById( "k_ime" ).value;
							
						if(k_ime)
						{
						$.ajax({
						type: 'post',
						url: 'Username-check.php',
						data: {
						k_ime:k_ime,
						},
						success: function (response) {
						$( '#status' ).html(response);
						if(response=="OK")	
						{
							return true;	
						}
						else
						{
							return false;	
						}
						}
						});
						}
						else
						{
						$( '#status' ).html("");
						return false;
						}
				}
			function checkage()
				{//dinamička provjera jesu li ispravno unesene godine
					var dob = document.getElementById("dob").value;
					if(dob < 6 || dob > 110)
					{
						$('#dobStatus').html('Neispravno unesene godine!').css('color', 'red');
						$('#salji').attr("disabled", true);
					}
					else 
					{
						$('#dobStatus').html('Uredu').css('color', 'green');
						$('#salji').attr("disabled", false);
					}

				}
				//validacija email-a pomoću regularnog izraza
			function validateEmail(email) //https://stackoverflow.com/questions/46155/validate-email-address-in-javascript
			 {
    			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    			return re.test(email);
				}
			function validate()
			{
				$("#result").text("");
				var email = $("#email").val();
				if (validateEmail(email)) 
				{
					$("#result").text(email + " je valjana email adresa :)");
					$("#result").css("color", "green");
					$('#salji').attr("disabled", false);
				} 
				else
				 {
					$("#result").text(email + " nije valjana email adresa :(");
					$("#result").css("color", "red");
					$('#salji').attr("disabled", true);
				}
				return false;
			}
			</script>

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

		<div class="wrapper"> <!-- https://codepen.io/ace-subido/pen/Cuiep -->
			<form class="form-signin" action="" method="post">
				<h2 class="form-signin-heading">Registrirajte se </h2>
				</br>
				<label for="ime">Ime: </label>
				<input class="form-control" type="text" name="ime" value="" id="ime" required/>
				<br/><br/>
				<label for="prezime">Prezime: </label>
				<input class="form-control" type="text" name="prezime" value="" id="prezime" required/>
				<br/><br/> 
				<label for="email">Email: </label>
				<input class="form-control" type="text" name="email" value="" id="email" onkeyup="validate()" required/>
				<span id="result"></span>
				<br/><br/>
				<label for="dob">Dob: </label>
				<input class="form-control" type="number" name="dob" value="" id="dob" onkeyup="checkage()" required/>
				<span id="dobStatus"></span>
				<br/><br/>
				<label for="k_ime">Korisničko ime: </label>
				<input class="form-control" type="text" name="k_ime" value="" id="k_ime" onblur="checkname()" required/>
				<span id="status"></span>
				<br/><br/>
				<label for="lozinka">Lozinka: </label>
				<input class="form-control" type="password" name="lozinka" value="" id="lozinka" required/>
				<br/><br/>
				<label for="lozinkaPonovno">Ponovite lozinku: </label>
				<input class="form-control" type="password" name="lozinkaPonovno" value="" id="lozinkaPonovno" required/>
				<span id='message'>Ne podudarane lozinke</span>
				<br/><br/>
				<input class="btn btn-lg btn-primary btn-block" type="submit" name="salji" id="salji"value="Dodaj korisnika" required/>
				</br>
				<p>Već ste registrirani? <a href="login.php">Prijavite se ovdje!</a></p>
				
				<script>//provjera ponovljene lozinke
				$('#lozinka, #lozinkaPonovno').on('keyup', function () {
				if ($('#lozinka').val() == $('#lozinkaPonovno').val()) {
					$('#message').html('Ispravno').css('color', 'green');
					$('#salji').attr("disabled", false);
				} else {
					$('#message').html('Lozinke se ne podudaraju!!!').css('color', 'red');
					$('#salji').attr("disabled", true);
				}
				}); //https://stackoverflow.com/questions/21727317/how-to-check-confirm-password-field-in-form-without-reloading-page
				</script>
	<?php
		include 'connection.php';
		if(isset($_POST["salji"])){
			if($_POST["ime"]!=null && $_POST["prezime"]!=null && $_POST["email"]!=null && $_POST["k_ime"]!=null && $_POST["lozinka"]!=null && $_POST["dob"] && $_POST["lozinkaPonovno"]){//provjera jesu li uneseni svi podatci
			$ime=$_POST["ime"];
			$prezime=$_POST["prezime"];
			$email=$_POST["email"];
			$k_ime=$_POST["k_ime"];
			$lozinka=$_POST["lozinka"];
			$dob=$_POST["dob"];
			$lozinkaPonovno=$_POST["lozinkaPonovno"];
			if($lozinka==$lozinkaPonovno){
			$sql = "SELECT * FROM user WHERE user_name='{$k_ime}' AND pass='{$lozinka}';";//provjera postoji li već korisnik
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
				echo "Korisnik već postoji.";	   
			} 
			else {			
				$sql = "INSERT INTO user (ID,user_name,pass,email,name,surname,age)
				VALUES ('NULL','{$k_ime}','{$lozinka}','{$email}','{$ime}','{$prezime}',{$dob});";//unos korisnika u bazu
				try {
					$conn->exec($sql);
					 echo "<script type='text/javascript'>alert('Uspješno ste registrirani {$ime} {$prezime}!')</script>";
				}
				catch(PDOException $e)
				{
					echo $sql . "<br>" . $e->getMessage();
				}
				
			}
		}
	}
		else echo "<p style='color:red'>Niste unijeli sve podatke za korinika.</p>";
} 

            if(isset($_POST["salji"]) && $_POST["k_ime"]!=null && $_POST["lozinka"]!=null){//prijava novo registriranog korisnika
                $k_ime=$_POST["k_ime"];
                $lozinka=$_POST["lozinka"];
                include 'connection.php';
                $sql = "SELECT * FROM user WHERE user_name='{$k_ime}' AND pass='{$lozinka}';";
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
                        $_SESSION["k_ime"]=$k_ime;
                        $_SESSION["ID"]=$row["ID"];
                        $_SESSION["email"]=$row["email"];
                        $_SESSION["ime"]=$row["name"];
                        $_SESSION["prezime"]=$row["surname"];
						echo "<script>document.location = 'index.php';</script>";
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
