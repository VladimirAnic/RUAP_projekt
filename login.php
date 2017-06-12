<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
		<h3>Prijavi se</h3>
        <form method="post">
            <label for="k_ime">Korisničko ime: </label>
            <input type="text" name="k_ime" value="" id="k_ime"/>
            <br/><br/>
            <label for="lozinka">Lozinka: </label>
            <input type="password" name="lozinka" value="" id="lozinka"/>
            <br/><br/>
            <input type="submit" name="salji" value="Pošalji"/>
        </form>
    </body>
</html>
<?php
	if(isset($_POST["salji"]) && $_POST["k_ime"]!=null && $_POST["lozinka"]!=null){
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
				header("Location:overview.php");
			}
               
        } else {
			$_SESSION["ime"]=null;
            echo "<br/>Krivo korisničko ime ili lozinka. Pokušajte ponovo.";
        }
    } 
?>
