<?php
  include 'connection.php';
    if(isset($_POST['k_ime']))
    {
        
        $k_ime = $_POST['k_ime'];

    $sql = "SELECT user_name FROM user WHERE user_name='$k_ime';";
    try {
                    $mid =$conn->prepare($sql);
                    $mid->execute();
                    $result=$mid->fetchAll();
                }
                catch(PDOException $e)
                {
                    echo $sql . "<br>" . $e->getMessage();
                }
    if($mid->rowCount() > 0)
    {
     echo '<div style="color: red;"> <b>'.$k_ime.'</b> već postoji! </div>';
    }
    else
    {
    echo 'OK';
    }
    exit();
    }

?>