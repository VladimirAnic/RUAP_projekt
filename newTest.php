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
		<h3>Upišite vaše podatke</h3>
        <form action="" method="post">
            <label for="STG">Vrijeme učenja za predmet: </label>
            <input type="text" name="STG" value="" id="STG"/>
            <br/><br/>
            <label for="SCG">Broj ponavljanja za predmet: </label>
			 <input type="text" name="SCG" value="" id="SCG"/>
            <br/><br/> 
            <label for="STR">Vrijeme učenja za povezane predmete: </label>
            <input type="text" name="STR" value="" id="STR"/>
            <br/><br/>
            <label for="LPR">Uspješnost na ispitu za predmet: </label>
			<input type="text" name="LPR" value="" id="LPR"/>
            <br/><br/>
			<label for="PEG">Uspješnost na ispitu za povezane predmete: </label>
			<input type="text" name="PEG" value="" id="PEG"/>
            <br/><br/>
            <input type="submit" name="salji" value="Pošalji"/>
        </form>
    </body>
</html>
<?php
    include 'connection.php';
		if(isset($_POST["salji"])){
			if($_POST["STG"]!=null && $_POST["SCG"]!=null && $_POST["STR"]!=null && $_POST["LPR"]!=null && $_POST["PEG"]!=null){
                $STG=$_POST["STG"];
                $RGO=$_POST["SCG"];
                $STRO=$_POST["STR"];
                $EPRO=$_POST["LPR"];
                $EPG=$_POST["PEG"];	
                $user_ID=$_SESSION["ID"];

                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                $url = 'https://ussouthcentral.services.azureml.net/workspaces/5b9e19cdee1747c6bb1eaa7b98079b24/services/aa4858cde55b4e90b275bae5b20b7281/execute?api-version=2.0&details=true';
                $api_key = 'dFahZBb/4lW8yrWJrrBinBmmgif24LM4nTACKvANpjmoUknQy4WUGfEcEU3D107wlnAZWozsUqCYZOZWjNY/mg==';


                $data = array(
                    'Inputs'=> array(
                        'input1'=> array(
                            'ColumnNames' => array("STG", "SCG", "STR", "LPR", "PEG", "UNS"),
                        'Values' => array( array("$STG" , "$RGO" , "$STRO", "$EPRO" , "$EPG" , ""))
                        ),
                    ),
                        'GlobalParameters' => new StdClass(),
                );
                $body = json_encode($data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.$api_key, 'Accept: application/json'));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response  = json_decode(curl_exec($ch), true);
                //echo 'Curl error: ' . curl_error($ch);
                curl_close($ch);

                //var_dump ($response);
                $knowledge = $response['Results']['output1']['value']['Values']['0']['10'];
                //echo $result ;

                $sql = "INSERT INTO entries (ID,STG,RGO,STRO,EPRO,EPG,knowledge_level,user_ID) 
                VALUES ('NULL',{$STG},{$RGO},{$STRO},{$EPRO},{$EPG},'{$knowledge}',$user_ID);";
                try {
                    $conn->exec($sql);
                    echo "Uspješno dodani novi podaci.<br/>Vaše znanje je {$knowledge}!<br/>";
                }
                catch(PDOException $e)
                {
                    echo $sql . "<br>" . $e->getMessage();
                }
		    }
		}
		else echo "Niste unijeli sve podatke.";
	 
    echo "<a href='overview.php'>Pregled statistike </a>";
     echo "<a href='signout.php'>Odjava</a>";
?>