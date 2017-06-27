<?php
	session_start();
	if($_SESSION["ime"]!=null )
            {
                echo"<h1 class = 'text-center'>Testiranje vašeg znanja</h1>";
			    echo "<h4 class='text-right' align='center'>Dobrodošao/la {$_SESSION["ime"]}!</h4>";
            }
    else header("Location:index.php");
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
                margin-top: 80px;
            margin-bottom: 80px;
            }
             .form-signin {
            max-width: 600px;
            padding: 15px 35px 45px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid rgba(0,0,0,0.1); 
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
                    <li class="active"><a href='index.php'>Početna stranica </a></li>
                    <li class="active"><a href='overview.php'>Pregled statistike </a></li>
                    <li class="active"><a href="signout.php">Logout</a></li>
                </div>
            </div>
        </nav>
        
        <div class="wrapper"> <!--https://www.w3schools.com/bootstrap/bootstrap_forms.asp 
                                https://bootsnipp.com/snippets/featured/advance-password-validation
                                 -->
            <form class="form-signin" action="" method="post">
                <h3>Upišite vaše podatke</br></br></h3>
                <label class="control-label col-sm-8" for="STG">Stupanj vremena koje je provedeno učeći za ciljni predmet: </label>
                <input type="number" step="0.01" min="0" max="1" name="STG" value="" id="STG"/>
                <br/><br/>
                <label class="control-label col-sm-8" for="SCG">Stupanj broja ponavljanja za ciljni predmet: </label>
                <input type="number" step="0.01" min="0" max="1" name="SCG" value="" id="SCG"/>
                <br/><br/> 
                <label class="control-label col-sm-8" for="STR">Stupanj vremena koje je provedeno učeći za povezane predmete: </label>
                <input type="number" step="0.01" min="0" max="1" name="STR" value="" id="STR"/>
                <br/><br/>
                <label class="control-label col-sm-8" for="LPR">Uspješnost na ispitu za povezani predmet: </label>
                <input type="number" step="0.01" min="0" max="1" name="LPR" value="" id="LPR"/>
                <br/><br/>
                <label class="control-label col-sm-8" for="PEG">Uspješnost na ispitu za ciljni predmet: </label>
                <input type="number" step="0.01" min="0" max="1" name="PEG" value="" id="PEG"/>
                <br/><br/>
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="salji" value="Pošalji" id="salji"/>
                <span id="Status"></span>

                <?php
                    include 'connection.php';
                    //API za korištenje Azure ML Studia(opisan u seminaru)
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
                                curl_close($ch);

                                $knowledge = $response['Results']['output1']['value']['Values']['0']['10'];
                                //prevođenje razine znanja s engleskog na hrvatski jezik
                                if($knowledge=="Very Low") $knowledge="Vrlo Nisko";
                                else if($knowledge=="Low") $knowledge="Nisko";
                                else if($knowledge=="Middle") $knowledge="Srednje";
                                else $knowledge="Visoko";

                                $sql = "INSERT INTO entries (ID,STG,RGO,STRO,EPRO,EPG,knowledge_level,user_ID) 
                                VALUES ('NULL',{$STG},{$RGO},{$STRO},{$EPRO},{$EPG},'{$knowledge}',$user_ID);";
                                try {
                                    $conn->exec($sql);
                                    echo "<script type='text/javascript'>alert('Uspješno dodani novi podaci. Vaše znanje je {$knowledge}!')</script>";
                                    echo "<script>document.location = 'overview.php';</script></script>";
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            }
                        else echo "<p style='color:red'>Niste unijeli sve podatke.</p>";
                        }                   
                    ?>
                <p style="color:steelblue">*Vrijednosti moraju biti između 0 i 1</p>
            </form>
        </div>
    </body>
</html>