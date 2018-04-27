 <?php
$jsonString = file_get_contents('./json/info.json');
$data = json_decode($jsonString, true);
//affichage du contenu
// echo "Début : <pre>";print_r($data);echo "</pre></br>";

// modification
$option = $_POST['options'];
if ($option==0) {
	$data["settings"]["mode"]=$option;
}
else {
	$data["settings"]["mode"]=$option;
	$data["settings"]["switch"]["theme"]["value"]=isset($_POST["themeSwitch"]);
	$data["settings"]["switch"]["theme"]["text"]='"'.$_POST["nomtheme"].'"';
	$data["settings"]["switch"]["bouffe"]["value"]=isset($_POST["bouffeSwitch"]);
	$data["settings"]["switch"]["bouffe"]["type"]='"'.$_POST["bouffeType"].'"';
	$data["settings"]["switch"]["bouffe"]["diffpour2"]=isset($_POST["bouffeIsPromoFor2"]);
	$data["settings"]["switch"]["bouffe"]["price"]=$_POST["bouffePriceUnit"];
	$data["settings"]["switch"]["bouffe"]["pricefor2"]=$_POST["bouffePriceFor2"];
	$data["settings"]["switch"]["boisson"]["value"]=isset($_POST["boissonSwitch"]);
	$data["settings"]["switch"]["boisson"]["type"]='"'.$_POST["boissonType"].'"';
	$data["settings"]["switch"]["boisson"]["diffpour2"]=isset($_POST["boissonIsPromoFor2"]);
	$data["settings"]["switch"]["boisson"]["price"]=$_POST["boissonPriceUnit"];
	$data["settings"]["switch"]["boisson"]["pricefor2"]=$_POST["boissonPriceFor2"];
	$data["refresh"]=date('Y-m-d') .' '. date('H:i:s');
}
// fin de modif

// affichage du contenu
// echo "Fin : <pre>";print_r($data);echo "</pre></br>";
$newJsonString = json_encode($data);
file_put_contents('./json/info.json', $newJsonString);

// echo '<meta http-equiv="refresh" content="0;URL=./" />';
// exit();
 ?>