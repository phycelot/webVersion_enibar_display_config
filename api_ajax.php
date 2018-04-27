<?php
date_default_timezone_set('Europe/Paris'); setlocale(LC_TIME, "fr_FR.UTF8");// pour forcer l'affichage heure française
mb_internal_encoding('UTF-8_general_ci');

include('dbconnection.php');
include('functions.php');
//wip faire des verif que les users ont les droits de faire les requetes avant de les faires
if(mysqli_connect_errno())
{
echo '<p>La connexion au serveur MySQL a échoué: '.mysqli_connect_error().'</p>';
}
$action=$_GET['action'];
if ($action=='detail_event_return_text') {
	$id=$_GET['id'];
	$req='SELECT * FROM `event` NATURAL JOIN type WHERE `event_id`='.$id;
	$result=mysqli_query($connect, $req);
	$resultat = mysqli_fetch_assoc($result);
	echo "<p>".$resultat['type_showName'].' '.$resultat['theme'].'</br> Date: '.$resultat['date']."</p>";
	if ($resultat['detail']!=""){
		echo "<p>detail : ".$resultat['detail']."</p>";
	}
	if ($resultat['beerPong']=='1'){
		echo 'BeerPong</br>';
	}
	if ($resultat['extension']=='1'){
		echo 'Extension</br>';
	}
	$req='SELECT boisson_name,boisson_one_price,boisson_two_price FROM boisson WHERE `event_id`='.$id;
// 	echo $req;
	$result=mysqli_query($connect, $req);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<p>Boisson : ".$row['boisson_name']."</br>";
			echo "prix unitaire :".$row['boisson_one_price'].'</br>';
			if ($row['boisson_two_price']!=0) {
				echo "prix pour deux :".$row['boisson_two_price'].'</br>';
			}
			echo "</p>";
		}
	};
	$req='SELECT bouffe_name,bouffe_one_price,bouffe_two_price FROM bouffe WHERE `event_id`='.$id;
// 	echo $req;
	$result=mysqli_query($connect, $req);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<p>Bouffe : ".$row['bouffe_name']."</br>";
			echo "prix unitaire :".$row['bouffe_one_price'].'</br>';
			if ($row['bouffe_two_price']!=0) {
				echo "prix pour deux :".$row['bouffe_two_price'].'</br>';
			}
			echo "</p>";
		}
	};
} elseif ($action=='get_bouffe_list') {
	echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" align="center"><thead><tr><th></th><th class="mdl-data-table__cell--non-numeric">Type</th><th></th></tr></thead><tbody>';
	$req='SELECT * FROM `bouffe`';
	$result=mysqli_query($connect, $req);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="event-add-bouffe-list-checkbox-'.$row['bouffe_id'].'"><input type="checkbox" id="event-add-bouffe-list-checkbox-'.$row['bouffe_id'].'" class="mdl-checkbox__input"></label></td><td>'.$row['bouffe_name'].'</td><td><button id="event-add-bouffe-list-price-'.$row['bouffe_id'].'" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">more_vert</i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="event-add-bouffe-list-price-'.$row['bouffe_id'].'"><p class="mdl-menu__item">unit : '.$row['bouffe_one_price'].'€</p><p class="mdl-menu__item">double : '.$row['bouffe_two_price'].'€</p></ul></td></tr>';
		}
	}
	echo "</tbody></table>";
} elseif ($action=='main_list_event') {
	$req='SELECT type_id FROM type';
	$result=mysqli_query($connect, $req);
	echo '<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp" align="center"><p>(click for detail)</p><thead><tr><th>Event</th><th>Date</th><th>Theme</th></tr></thead><tbody>';
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$req2='SELECT theme,date,type_showName,event_id FROM `event` NATURAL JOIN type WHERE `type_id`='.$row['type_id'].' ORDER BY date DESC';
			$resultat=mysqli_query($connect, $req2);
			if ($row2=mysqli_fetch_assoc($resultat)){
				echo'<tr id="list-event-';
		    echo $row2['event_id'];
		    echo '" onClick="updateShow(this.id);">';
				echo"<td>";
				echo $row2['type_showName'];
				echo"</td>";
				echo"<td>";

				echo substr($row2['date'], 0, -6);
				echo"</td>";
				echo"<td>";
				echo $row2['theme'];
				echo"</td>";
				echo"</tr>";
			}
		
		}
	}
	echo  "</tbody>
	      </table>";
} elseif ($action=='update_list') {
	if (isset($_GET['typeID'])){
		$req='SELECT theme,date,type_showName,event_id FROM event NATURAL JOIN type where theme LIKE "%'.htmlentities($_GET['search']).'%" and date LIKE "%'.$_GET['date'].'%" and type_id='.$_GET['typeID'].' ORDER BY date DESC';	
	} else {
		$req='SELECT theme,date,type_showName,event_id FROM event NATURAL JOIN type where theme LIKE "%'.htmlentities($_GET['search']).'%" and date LIKE "%'.$_GET['date'].'%" ORDER BY date DESC';
	}
	$result=mysqli_query($connect, $req);
	if (mysqli_num_rows($result) > 0) {
	echo '<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp" align="center">
	<p>(click for detail)</p>
	                      <thead>
	                        <tr>
	                          <th>Event</th>
	                          <th>Date</th>
	                          <th>Theme</th>
	                        </tr>
	                      </thead>
	                      <tbody>';
		while($row = mysqli_fetch_assoc($result)) {
			echo'<tr id="list-event-';
	    echo $row['event_id'];
	    echo '" onClick="updateShow(this.id);">';
			echo"<td>";
			echo $row['type_showName'];
			echo"</td>";
			echo"<td>";
			echo substr($row['date'], 0, -6);
			echo"</td>";
			echo"<td>";
			echo $row['theme'];
			echo"</td>";
			echo"</tr>";
		}
	echo  "</tbody>
	      </table>";
	} else {
		echo "<h2>nop</h2>";
	}
} elseif ($action=='update_type_list') {
	$req='SELECT `type_id`,`type_showName` FROM `type`';
	$result=mysqli_query($connect, $req);
	if (mysqli_num_rows($result) > 0) {
		echo "<option value=-1>----</option>";
		while($row = mysqli_fetch_assoc($result)) {
			echo "<option value=".$row['type_id'].">".$row['type_showName']."</option>";
		}
	}
} elseif ($action=='new_event') {
// 	echo "<p>new_event	</p>";
	$type_id=$_GET['type_event'];
	if($_GET['theme']){$theme=htmlentities($_GET['theme']);} else {$theme=NULL;}
	$date=$_GET['date'];
	if ($_GET['detail']){
		$detail=htmlentities($_GET['detail']);
	} else {
		$detail=NULL;
	}
	if(isset($_GET['isBeerPong'])){$isBeerPong=true;}else{$isBeerPong=false;}
	if(isset($_GET['isExtension'])){$isExtension=true;}else{$isExtension=false;}
	if(isset($_GET['isVisible'])){$isVisible=true;}else{$isVisible=false;}
	$req='INSERT INTO `event`(`type_id`, `theme`, `date`, `detail`, `beerPong`, `extension`,`visible`) VALUES ('.$type_id.',"'.$theme.'","'.$date.'","'.$detail.'","'.$isBeerPong.'","'.$isExtension.'","'.$isVisible.'");';
	$result=mysqli_query($connect, $req);
	if ($result) { echo "ajout réussi</br>";}
	$insert_id=mysqli_insert_id($connect);
	echo "au rang ".$insert_id."</br></br></br>";
	$response = json_decode($_GET['json'], true);
	echo "<pre>";print_r($response);echo "</pre></br>";
	for ($i=0; $i<count($response['bouffe']); $i++) {
		$req="";
		$req ='INSERT INTO `bouffe`(`bouffe_name`, `bouffe_one_price`, `bouffe_two_price`, `event_id`) VALUES ("'.$response['bouffe'][$i]['type'].'",'.$response['bouffe'][$i]['unit_price'].','.$response['bouffe'][$i]['double_price'].','.$insert_id.');';
		echo $req;
		$ret=mysqli_query($connect, $req);
		echo '</br> ret :';
		echo $ret;
		echo '</br>';
	};
	for ($j=0; $j<count($response['boisson']); $j++) {
		$req="";
		$req ='INSERT INTO `boisson`(`boisson_name`, `boisson_one_price`, `boisson_two_price`, `event_id`) VALUES ("'.$response['boisson'][$j]['type'].'",'.$response['boisson'][$j]['unit_price'].','.$response['boisson'][$j]['double_price'].','.$insert_id.');';
		echo $req;
		$ret=mysqli_query($connect, $req);
		echo '</br> ret :';
		echo $ret;
		echo '</br>';
	};
	echo '<p>end</p>';
}
elseif ($action=='get_boisson_list') {
	echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" align="center"><thead><tr><th></th><th class="mdl-data-table__cell--non-numeric">Type</th><th></th></tr></thead><tbody>';
	$req='SELECT * FROM `boisson`';
	$result=mysqli_query($connect, $req);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="event-add-boisson-list-checkbox-'.$row['boisson_id'].'"><input type="checkbox" id="event-add-boisson-list-checkbox-'.$row['boisson_id'].'" class="mdl-checkbox__input"></label></td><td>'.$row['boisson_name'].'</td><td><button id="event-add-boisson-list-price-'.$row['boisson_id'].'" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">more_vert</i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="event-add-boisson-list-price-'.$row['boisson_id'].'"><p class="mdl-menu__item">unit : '.$row['boisson_one_price'].'€</p><p class="mdl-menu__item">double : '.$row['boisson_two_price'].'€</p></ul></td></tr>';
		}
	}
	echo "</tbody></table>";
} elseif ($action=='get_event_edit_info') {
	$id=$_GET["event_id"];
	$req='SELECT `type_id`, `theme`, `date`, `detail`, `beerPong`, `extension`, `visible` FROM `event` WHERE `event_id`='.$id;
	$result=mysqli_query($connect, $req);
	$row = mysqli_fetch_assoc($result);
	$req='SELECT `bouffe_name` AS type,`bouffe_one_price` AS unit_price,`bouffe_two_price` AS double_price FROM `bouffe` WHERE `event_id`='.$id;
	$result2=mysqli_query($connect, $req);
	$i=0;
	while($row2 = mysqli_fetch_assoc($result2)) {
		$bouffe[$i]=$row2;
		$i++;
	};
	$req='SELECT `boisson_name`AS type,`boisson_one_price`AS unit_price,`boisson_two_price` AS double_price FROM `boisson` WHERE `event_id`='.$id;
	$result2=mysqli_query($connect, $req);
	$i=0;
	while($row2 = mysqli_fetch_assoc($result2)) {
		$boisson[$i]=$row2;
		$i++;
	};
	$array = array('type_id' => $row['type_id'],'theme' => $row['theme'],'date' => $row['date'],'detail' => $row['detail'],'beerPong' => $row['beerPong'],'extension' => $row['extension'],'visible' => $row['visible'], 'boisson' => $boisson, 'bouffe' => $bouffe);
	echo json_encode($array);
} elseif ($action=='edit_event') {
	$id=htmlentities($_GET["event_id"]);
	$type_id=$_GET['type_event'];
	if($_GET['theme']){$theme="'".addslashes(htmlentities($_GET['theme']))."'";} else {$theme='NULL';}
	$date=$_GET['date'];
	if ($_GET['detail']){$detail="'".addslashes(htmlentities($_GET['detail']))."'";} else {$detail='NULL';}
	if(isset($_GET['isBeerPong'])){$isBeerPong=1;}else{$isBeerPong=0;}
	if(isset($_GET['isExtension'])){$isExtension=1;}else{$isExtension=0;}
	if(isset($_GET['isVisible'])){$isVisible=1;}else{$isVisible=0;}
	$req = "UPDATE `event` SET `type_id`=".$type_id.",`theme`=".$theme.",`date`='".$date."',`detail`=".$detail.",`beerPong`=".$isBeerPong.",`extension`=".$isExtension.",`visible`=".$isVisible." WHERE `event_id`=".$id.";";
	echo $req;
	$resultat=mysqli_query($connect, $req);
	echo $resultat;
	$req = 'DELETE FROM `bouffe` WHERE `event_id`='.$id.';';
	$resultat=mysqli_query($connect, $req);
	echo $resultat;
	$req = 'DELETE FROM `boisson` WHERE `event_id`='.$id.';';
	$resultat=mysqli_query($connect, $req);
	echo $resultat;
	$response = json_decode($_GET['json'], true);
	for ($j=0; $j<count($response['boisson']); $j++) {
		$req ='INSERT INTO `boisson`(`boisson_name`, `boisson_one_price`, `boisson_two_price`, `event_id`) VALUES ("'.$response['boisson'][$j]['type'].'",'.$response['boisson'][$j]['unit_price'].','.$response['boisson'][$j]['double_price'].','.$id.');';
		$resultat=mysqli_query($connect, $req);
		echo $resultat;
	};
	for ($j=0; $j<count($response['bouffe']); $j++) {
		$req ='INSERT INTO `bouffe`(`bouffe_name`, `bouffe_one_price`, `bouffe_two_price`, `event_id`) VALUES ("'.$response['bouffe'][$j]['type'].'",'.$response['bouffe'][$j]['unit_price'].','.$response['bouffe'][$j]['double_price'].','.$id.');';
		$resultat=mysqli_query($connect, $req);
		echo $resultat;
	};
} elseif ($action=='connect') {
	if($_GET["how"]=='digit'){
		$connection_bylogin=0;
		$connection_bydigit=1;
		$connexion_date = date('Y-m-d') .' '. date('H:i:s');
		$code=htmlspecialchars($_GET['code']);
		$req='SELECT * FROM `users` WHERE users_code='.$code;
		$result=mysqli_query($connect, $req);
		$row = mysqli_fetch_assoc($result);
		$timeStart= ($row["users_temporary_startTime"]);
		$timeEnd=($row["users_temporary_endTime"]);
		if ((($timeStart < $connexion_date) && ($connexion_date < $timeEnd)) && isset($row)) {
// 			echo json_encode($row);
			session_start();
    	$_SESSION['users_id'] = $row['users_id'];
			$_SESSION['users_level']= $row['users_level'];
// 			header("Refresh:0; url=config.php");
//     	exit();
			$connection_success=1;
		} else {
			echo "0";
			$connection_success=0;
		};
	} elseif ($_GET["how"]=='password'){
		$connection_bylogin=1;
		$connection_bydigit=0;
		$pseudo=htmlspecialchars($_GET['pseudo']);
		$password=htmlspecialchars($_GET['password']);
		$password = hash('sha512', $password);
		$req='SELECT * FROM `users` WHERE `users_name`="'.$pseudo.'" and `users_password`="'.$password.'"';
		$result=mysqli_query($connect, $req);
		$row = mysqli_fetch_assoc($result);
		if (isset($row)) {
			echo json_encode($row);
			session_start();
    	$_SESSION['users_id'] = $row['users_id'];
			$_SESSION['users_level']= $row['users_level'];
			$connection_success=1;
		} else {
			echo "0";
			$connection_success=0;
		};
	};
	$connexion_date = date('Y-m-d') .' '. date('H:i:s');
	$ip=get_ip();
	$req='INSERT INTO `connection`(`connection_success`, `connection_datetime`, `connection_ip`, `connection_bylogin`, `connection_bydigit`) VALUES ('.$connection_success.',"'.$connexion_date.'","'.$ip.'",'.$connection_bylogin.','.$connection_bydigit.')';
// 	echo $req;
	$result=mysqli_query($connect, $req);
} elseif ($action=='disconnect') {
	session_start();
	session_unset();
	session_destroy(); 
} elseif ($action=='reboot') {
	session_start();
	$connexion_date = date('Y-m-d') .' '. date('H:i:s');
	$req='INSERT INTO `asked_reboot`(`asked_reboot_datetime`, `users_id`) VALUES ("'.$connexion_date.'",'.$_SESSION['users_id'].');';
	$result=mysqli_query($connect, $req);
} elseif ($action=='testNbrCo') {
	$ip=get_ip();
	$req='SELECT COUNT(`connection_ip`) as howManyConnection FROM `connection` WHERE `connection_datetime` > DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND `connection_success`=0 AND `connection_ip`="'.$ip.'"';
	$result=mysqli_query($connect, $req);
	$row = mysqli_fetch_assoc($result);
	echo $row['howManyConnection'];
// 	echo $req;
} elseif ($action=='clean_events') {
	$req='TRUNCATE event';
	$result=mysqli_query($connect, $req);
	$req='TRUNCATE bouffe';
	$result.=mysqli_query($connect, $req);
	$req='TRUNCATE boisson';
	$result.=mysqli_query($connect, $req);
	echo $result;
} elseif ($action=='send_message') {
	session_start();
	echo $_SESSION['users_id'];
	$req='INSERT INTO `message`(`users_id`, `message_text`, `message_sendTime`) VALUES ('.$_SESSION['users_id'].',"'.addslashes(htmlentities($_GET['message'])).'",NOW());';
	$result=mysqli_query($connect, $req);
	echo $result;
} elseif ($action=='get_last_message') {
	$req="SELECT `users_name`,`message_text` FROM `message` NATURAL JOIN `users` ORDER BY `message_sendTime` DESC LIMIT ".$_GET["limit"];
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='get_last_connection') {
	$req="SELECT `connection_ip` FROM `connection` ORDER BY `connection_datetime` DESC LIMIT ".$_GET["limit"];
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='getUsersList') {
	$req="SELECT `users_id`,`users_name`,`users_level` FROM `users` where users_isTemporary=0";
	$query=addslashes(htmlentities($_GET['query']));
	if (isset($_GET['query'])){
		$req.=" AND users_name LIKE '%".$query."%'";	}
	if (isset($_GET['level'])){$req.=" AND users_level=".$_GET['level'];}
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='getTemporaryUsersList') {
	$req="SELECT `users_id`,`users_code`,`users_temporary_startTime`,`users_temporary_endTime` FROM `users` where users_isTemporary=1 AND NOW()<`users_temporary_endTime`";
	$query=addslashes(htmlentities($_GET['query']));
	if (isset($_GET['query'])){
		$req.=" AND users_name LIKE '%".$query."%'";	}
	if (isset($_GET['level'])){$req.=" AND users_level=".$_GET['level'];}
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='editUsers') {
	session_start();
	$_SESSION['users_level'];
	$_GET['users_id'];
	$do=$_GET['do'];
	if ($do=="delete") {
		$req="SELECT * FROM `users` WHERE `users_id`=".$_GET['users_id']." AND `users_level`<".$_SESSION['users_level'];
		$result=mysqli_query($connect, $req);
		$row = mysqli_fetch_assoc($result);
		if ($row==NULL){
			echo "you're not allow";
		} else {
			$req="DELETE FROM `users` WHERE `users_id`=".$_GET['users_id'];
			$result=mysqli_query($connect, $req);
			$row = mysqli_fetch_assoc($result);
			if ($row==NULL){
				echo "success";
			} else {
				echo "fail";
			}
		}
	} else if ($do=="changeLevel") {
		session_start();
		$_SESSION['users_level'];
		$req="UPDATE `users` SET `users_level`=".$_GET['level']." WHERE `users_id`=".$_GET['users_id'].' AND users_level<'.$_SESSION['users_level'];
		$result=mysqli_query($connect, $req);
		$row = mysqli_fetch_assoc($result);
		if ($row==NULL){
			echo "success";
		} else {
			echo "fail";
		}
	}
} elseif ($action=='editUsersAllow') {
	session_start();
	$_GET['users_id'];
	$req="SELECT * FROM `users` WHERE `users_id`=".$_GET['users_id']." AND `users_level`<".$_SESSION['users_level'];
	$result=mysqli_query($connect, $req);
	$row = mysqli_fetch_assoc($result);
	if ($row==NULL){
		echo 0;
	} else {
		echo 1;
	}
} elseif ($action=='getUsersLevelList') {
	$req="SELECT DISTINCT `users_level` FROM `users` ORDER BY `users_level`";
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='newUsers') {
	
	$req='SELECT * FROM `users` WHERE `users_name`="'.addslashes(htmlentities($_GET["pseudo"])).'"';
	$result=mysqli_query($connect, $req);
	$row = mysqli_fetch_assoc($result);
	if (!$row) {
		$pseudo=htmlspecialchars($_GET['pseudo']);
		$password=htmlspecialchars($_GET['password']);
		$password = hash('sha512', $password);
		$req='INSERT INTO `users`(`users_name`, `users_password`) VALUES ("'.$pseudo.'","'.$password.'")';
		$result=mysqli_query($connect, $req);
		if($result){
			$array = array('result' => "true",'message' => "new user successfully add");
		} else {
			$array = array('result' => "false",'message' => "fail to add new user");
		}
	} else {
		$array = array('result' => "false",'message' => "pseudo already used");
	}
	echo json_encode($array);
} elseif ($action=='changePassword') {
	session_start();
	$_SESSION['users_id'];
	$oldPassword=htmlspecialchars($_GET['oldPassword']);
	$oldPassword = hash('sha512', $oldPassword);
	$req='SELECT * FROM `users` WHERE `users_password`="'.$oldPassword.'" AND users_id='.$_SESSION['users_id'];
	$result=mysqli_query($connect, $req);
	$row = mysqli_fetch_assoc($result);
	if ($row) {
		$newPassword=htmlspecialchars($_GET['newPassword']);
		$newPassword = hash('sha512', $newPassword);
		$req='UPDATE `users` SET `users_password`="'.$newPassword.'" WHERE `users_id`='.$_SESSION['users_id'];
		$result=mysqli_query($connect, $req);
		if($result){
			$array = array('result' => "true",'message' => "password maj");
		} else {
			$array = array('result' => "false",'message' => "fail maj password");
		}
	} else {
		$array = array('result' => "false",'message' => "wrong password");
	}
	echo json_encode($array);
} elseif ($action=='deleteTemporaryUsers') {
	$req='DELETE FROM `users` WHERE `users_id`='.$_GET['users_id'];
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "code delete");
	} else {
		$array = array('result' => "false",'message' => "can't delete the code");
	}
	echo json_encode($array);
} elseif ($action=='newTemporaryCode') {
	$_GET['code'];
	$start=$_GET['startTime'];
	$end=$_GET['endTime'];
	$req='INSERT INTO `users`(`users_level`, `users_code`, `users_isTemporary`, `users_temporary_startTime`, `users_temporary_endTime`) VALUES (0,'.$_GET['code'].',1,"'.$start.'","'.$end.'")';
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "code add");
	} else {
		$array = array('result' => "false",'message' => "can't add the code");
	}
	echo json_encode($array);
} elseif ($action=='edit_default_length_info') {
	$req="SELECT `type_id`,`type_showName`,`type_default_length`,`type_default_length_extended` FROM `type`";
	if (isset($_GET['id'])) {
		$req.=' WHERE `type_id`='.$_GET['id'];
	}
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='set_default_length_info') {
	if ($_GET['default_length_extended']==""){
		$default_length_extended='null';
	}else{
		$default_length_extended=$_GET['default_length_extended'];
	}
		
	$req='UPDATE `type` SET `type_default_length`='.$_GET['default_length'].',`type_default_length_extended`='.$default_length_extended.' WHERE `type_id`='.$_GET['id'];
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='get_category_list') {
	$req='SELECT `category_id`, `category_name`, `category_isPression` FROM `category`';
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='get_product_list') {
	$req='SELECT `product_id`, `product_name` FROM `product` WHERE `category_id`='.$_GET['id'];
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='add_category') {
	$req='INSERT INTO `category`(`category_name`) VALUES ("'.addslashes(htmlentities($_GET['name'])).'")';
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='list_category') {
	$req='SELECT * FROM `category`';
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='delete_category') {
	$req='DELETE FROM `category` WHERE `category_id`='.$_GET['id'];
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='list_product') {
	$req='SELECT `product_id`,`product_name` FROM `product` WHERE `category_id`='.$_GET['category_id'];
	$result=mysqli_query($connect, $req);
	$i=0;
	$send;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=$row;
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='product_info') {
	$req='SELECT * FROM `product` WHERE `product_id`='.$_GET['product_id'];
	$result=mysqli_query($connect, $req);
	echo json_encode(mysqli_fetch_assoc($result));
} elseif ($action=='add_product') {
	$name=addslashes(htmlentities($_GET['name']));
	$isPression=htmlentities($_GET['isPression']);
	$category_id=htmlentities($_GET['category_id']);
	if ($isPression==0){
		$price=addslashes(htmlentities($_GET['price']));
		$req='INSERT INTO `product`(`product_name`, `category_id`, `product_price`, `product_isPression`) VALUES ("'.$name.'",'.$category_id.','.$price.','.$isPression.');';
	} else if ($isPression==1) {
		$demi_price=htmlentities($_GET['demi_price']);
		$pinte_price=htmlentities($_GET['pinte_price']);
		$metre_price=htmlentities($_GET['metre_price']);
		$type=htmlentities($_GET['type']);
		$brewery=addslashes(htmlentities($_GET['brewery']));
		$from=addslashes(htmlentities($_GET['from']));
		$degree=htmlentities($_GET['degree']);
		$req='INSERT INTO `product`(`product_name`, `category_id`, `product_isPression`, `product_pression_price_demi`, `product_pression_price_pinte`, `product_pression_price_metre`, `product_pression_brewery`, `product_pression_type`, `product_pression_from`, `product_pression_degree`) VALUES ("'.$name.'",'.$category_id.','.$isPression.','.$demi_price.','.$pinte_price.','.$metre_price.',"'.$brewery.'","'.$type.'","'.$from.'",'.$degree.');';
	}
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='edit_product') {
	$name=addslashes(htmlentities($_GET['name']));
	$isPression=htmlentities($_GET['isPression']);
	$category_id=htmlentities($_GET['category_id']);
	$product_id=htmlentities($_GET['product_id']);
	if ($isPression==0){
		$price=htmlentities($_GET['price']);
		$req='UPDATE `product` SET `product_name`="'.$name.'",`category_id`='.$category_id.',`product_price`='.$price.',`product_isPression`='.$isPression.' WHERE `product_id`='.$product_id;
	} else if ($isPression==1) {
		$demi_price=htmlentities($_GET['demi_price']);
		$pinte_price=htmlentities($_GET['pinte_price']);
		$metre_price=htmlentities($_GET['metre_price']);
		$type=htmlentities($_GET['type']);
		$brewery=addslashes(htmlentities($_GET['brewery']));
		$from=addslashes(htmlentities($_GET['from']));
		$degree=htmlentities($_GET['degree']);
		$req='UPDATE `product` SET `product_name`="'.$name.'",`category_id`='.$category_id.',`product_isPression`='.$isPression.',`product_pression_price_demi`='.$demi_price.',`product_pression_price_pinte`='.$pinte_price.',`product_pression_price_metre`='.$metre_price.',`product_pression_brewery`="'.$brewery.'",`product_pression_type`="'.$type.'",`product_pression_from`="'.$from.'",`product_pression_degree`='.$degree.' WHERE `product_id`='.$product_id;
	}
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='product_delete') {
	$req='DELETE FROM `product` WHERE `product_id`='.$_GET['product_id'];
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='category_info') {
	$req='SELECT * FROM `category` WHERE `category_id`='.$_GET['category_id'];
	$result=mysqli_query($connect, $req);
	echo json_encode(mysqli_fetch_assoc($result));
} elseif ($action=='edit_category') {
	$name=addslashes(htmlentities($_GET['name']));
	$category_id=htmlentities($_GET['category_id']);
	$req='UPDATE `category` SET `category_name`="'.$name.'" WHERE `category_id`='.$category_id;
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='delete_event') {
	$req='DELETE FROM `event` WHERE `event_id`='.$_GET['event_id'];
	$result=mysqli_query($connect, $req);
	if($result){
		$array = array('result' => "true",'message' => "success");
	} else {
		$array = array('result' => "false",'message' => "fail");
	}
	echo json_encode($array);
} elseif ($action=='isRebootAsked') {
	$req='SELECT * FROM `asked_reboot` WHERE `asked_reboot_datetime` > '.$_GET['pageLoadTime'];
	$result=mysqli_query($connect, $req);
	if($row = mysqli_fetch_assoc($result)){
		$array = array('result' => "true");
	} else {
		$array = array('result' => "false");
	}
	echo json_encode($array);
} elseif ($action=='save_config_affichage') {
	$response = json_decode($_GET['config'], true);
	$todoreq=[];
	if (isset($_GET['config_id'])){
		$config_id=$_GET['config_id'];
	} else {
		$config_id=1;
	}
	$req='DELETE FROM `affichage_config_category` WHERE `affichage_config_id`='.$config_id.';';
	$todoreq.=$req;
	$result=mysqli_query($connect, $req);
	for ($i=0; $i<count($response); $i++) {
		$req='INSERT INTO `affichage_config_category`(`category_id`, `affichage_config_category_isVisible`, `affichage_config_id`) VALUES ('.$response[$i]['category_id'].','.$response[$i]['visible'].','.$config_id.');';
		$todoreq.=$req;
		$result=mysqli_query($connect, $req);
		$affichage_config_category_id=mysqli_insert_id($connect);
		$req='DELETE FROM `affichage_config_product` WHERE `affichage_config_product_id`='.$affichage_config_category_id.';';
		$todoreq.=$req;
		$result=mysqli_query($connect, $req);
		for ($j=0; $j<count($response[$i]['product']); $j++) {
			$req='INSERT INTO `affichage_config_product`(`product_id`, `affichage_config_id`, `affichage_config_category_id`) VALUES ('.$response[$i]['product'][$j]['product_id'].','.$config_id.','.$affichage_config_category_id.');';
			$todoreq.=$req;
			$result=mysqli_query($connect, $req);
			
		};
	};
	echo json_encode($todoreq);
} elseif ($action=='get_config_affichage') {
	$toSend='';
	if (isset($_GET['actual'])){
		$req='SELECT * FROM `affichage_config` WHERE `affichage_config_isActual`=1;';
		$toSend+=$req;
		$result=mysqli_query($connect, $req);
		$row = mysqli_fetch_assoc($result);
		$config_id=$row['affichage_config_id'];
	} else {
		$config_id=$_GET['config_id'];
	}
	$req='SELECT * FROM `affichage_config` WHERE `affichage_config_id`='.$config_id;
	$toSend+=$req;
	$result=mysqli_query($connect, $req);
	$row = mysqli_fetch_assoc($result);
	$send['config']=$row;
	$req='SELECT * FROM `affichage_config_category` WHERE `affichage_config_id`='.$config_id;
	$result=mysqli_query($connect, $req);
	$i=0;
	while($row = mysqli_fetch_assoc($result)) {
		$req='SELECT * FROM `category` WHERE `category_id`='.$row['category_id'];
		$result2=mysqli_query($connect, $req);
		$row2 = mysqli_fetch_assoc($result2);
		$send['affichageConfig'][$i]=array("category_name" => $row2['category_name'],'category_id' => $row['category_id'],'visible'=> $row['affichage_config_category_isVisible'], 'category_isPression' => $row2['category_isPression'],'product'=> []);
		$req='SELECT * FROM `affichage_config_product` WHERE `affichage_config_category_id`='.$row['affichage_config_category_id'];
		$result3=mysqli_query($connect, $req);
		$j=0;
		while($row3 = mysqli_fetch_assoc($result3)) {
			$req='SELECT * FROM `product` WHERE `product_id`='.$row3['product_id'];
			$result4=mysqli_query($connect, $req);
			$row4 = mysqli_fetch_assoc($result4);
			if ($row4['product_isPression']=='1') {
				$send['affichageConfig'][$i]['product'][$j]=array("product_name" => $row4['product_name'],'product_id' => $row4['product_id'], "product_isPression" => $row4['product_isPression'], "product_pression_price_demi"  => $row4['product_pression_price_demi'], "product_pression_price_pinte"  => $row4['product_pression_price_pinte'], "product_pression_price_metre"  => $row4['product_pression_price_metre'], "product_pression_brewery"  => $row4['product_pression_brewery'], "product_pression_type"  => $row4['product_pression_type'], "product_pression_from"  => $row4['product_pression_from'], "product_pression_degree"  => $row4['product_pression_degree']) ;
			} else {
				$send['affichageConfig'][$i]['product'][$j]=array("product_name" => $row4['product_name'],'product_id' => $row4['product_id'], "product_isPression" => $row4['product_isPression'], "product_price" => $row4['product_price'] ) ;
			}
			$j++;
		};
		$i++;
	};
	echo json_encode($send);
} elseif ($action=='bug_report') {
	$title=addslashes(htmlentities($_GET['title']));
	$text=addslashes(htmlentities($_GET['text']));
	$req='INSERT INTO `bug_report`(`bug_report_title`, `bug_report_text`) VALUES ("'.$title.'","'.$text.'")';
	$result=mysqli_query($connect, $req);
	if(!($row = mysqli_fetch_assoc($result))){
		$array = array('result' => "true");
	} else {
		$array = array('result' => "false");
	}
	echo json_encode($array);
} elseif ($action=='get_event_list_affichage') {
	$req='SELECT `theme`,`date`,`type_showName` AS `type`,`detail` FROM `event` NATURAL JOIN `type` WHERE `visible`=1 AND `date` > NOW() ORDER BY `date` ASC LIMIT 7';
	$result=mysqli_query($connect, $req);
	$i=0;
	while($row = mysqli_fetch_assoc($result)) {
		$send[$i]=array('theme' => $row['theme'],'date' => $row['date'], 'detail'=> $row['detail'], 'type' => $row['type']);
		$i++;
	}
	echo json_encode($send);	
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {
} elseif ($action=='') {

}

// htmlentities() addslashes()
mysqli_close($conn);
?>