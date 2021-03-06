<?php
//docvaćanje podataka za vizualizaciju
include 'connection.php';

 $sql = "SELECT `knowledge_level`, COUNT(`knowledge_level`) AS Broj_pojavljivanja FROM `entries`,`user` WHERE user_ID='{$_SESSION["ID"]}' AND user_ID=user.ID GROUP BY `knowledge_level`;";
//https://stackoverflow.com/questions/7654978/using-count-to-find-the-number-of-occurrences
    try {
		   $mid =$conn->prepare($sql);
		   $mid->execute();
		   $result=$mid->fetchAll();
		}
		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}

$data = array(
    // dohvaćanje stupaca iz tablice i sql upita za vizualizaciju
    'cols' => array(
        array('type' => 'string', 'label' => 'knowledge_level'),
        array('type' => 'number', 'label' => 'Broj_pojavljivanja')
    ),
    'rows' => array()
);

foreach ($result as $row) {
    $data['rows'][] = array('c' => array(
        array('v' => $row['knowledge_level']),
        array('v' => $row['Broj_pojavljivanja'])
));
}

?>