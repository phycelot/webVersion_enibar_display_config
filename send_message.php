 <?php

$jsonString = file_get_contents('./json/message.json');
$data = json_decode($jsonString, true);
date_default_timezone_set('Europe/Paris');
//affichage du contenu
function get_ip() {
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}

// modification
$text = $_POST['message']; //à proteger
$pseudo = $_POST['pseudo']; //à proteger
//$text ='ntp';
// echo "<script>console.log('"+$text+"')</script>";
$ip= get_ip();
// $date= date('Y-m-d') .'_'. date('H:i:s');
$count=count($data["messages"]);
// $data["messages"][$count]["time"]=$date;
$data["messages"][$count]["time"]['year']=date('Y');
$data["messages"][$count]["time"]['month']=date('m');
$data["messages"][$count]["time"]['day']=date('d');
$data["messages"][$count]["time"]['hour']=date('H');
$data["messages"][$count]["time"]['minute']=date('i');
$data["messages"][$count]["time"]['second']=date('s');

$data["messages"][$count]["text"]=$text;
$data["messages"][$count]["pseudo"]=$pseudo;
$data["messages"][$count]["ip"]=$ip;

// fin de modif

// affichage du contenu
echo $data;
$newJsonString = json_encode($data);
file_put_contents('./json/message.json', $newJsonString);

// echo '<meta http-equiv="refresh" content="0;URL=./" />';
// exit();
 ?>