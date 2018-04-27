<?php
$jsonString = file_get_contents('./json/message.json');
$data = json_decode($jsonString, true);
//affichage du contenu
echo "<pre>";print_r($data);echo "</pre></br>";
?>