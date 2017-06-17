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
				<li class="active"><br/><a href='index.php'>Povratak na početnu stranicu</a></li>			</div>
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
				<input class="form-control" type="text" name="email" value="" id="email" required/>
				<br/><br/>
				<label for="dob">Dob: </label>
				<input class="form-control" type="text" name="dob" value="" id="dob" required/>
				<br/><br/>
				<span>
				<label for="k_ime">Korisničko ime: </label>
				<input class="form-control" type="text" name="k_ime" value="" id="k_ime" onblur="checkname()" required/>
				<span id="status"></span>
				<script>
				//http://talkerscode.com/webtricks/check%20username%20and%20email%20availability%20from%20database%20using%20ajax.php
				function checkname()
						{
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
				</script>
				</span>
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
				
				<script>
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
			if($_POST["ime"]!=null && $_POST["prezime"]!=null && $_POST["email"]!=null && $_POST["k_ime"]!=null && $_POST["lozinka"]!=null && $_POST["dob"] && $_POST["lozinkaPonovno"]){
			$ime=$_POST["ime"];
			$prezime=$_POST["prezime"];
			$email=$_POST["email"];
			$k_ime=$_POST["k_ime"];
			$lozinka=$_POST["lozinka"];
			$dob=$_POST["dob"];
			$lozinkaPonovno=$_POST["lozinkaPonovno"];
			if($lozinka==$lozinkaPonovno){
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
				echo "Korisnik već postoji.";	   
			} 
			else {			
				$sql = "INSERT INTO user (ID,user_name,pass,email,name,surname,age) 
				VALUES ('NULL','{$k_ime}','{$lozinka}','{$email}','{$ime}','{$prezime}',{$dob});";
				try {
					$conn->exec($sql);
					echo "Uspješno ste registrirani {$ime} {$prezime}!";
				}
				catch(PDOException $e)
				{
					echo $sql . "<br>" . $e->getMessage();
				}
			}
		}
	}
		else echo "Niste unijeli sve podatke za korinika.";
} 
?>
			</form>
		</div>
    </body>
</html>
