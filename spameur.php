<?php
session_start();
if (isset($_SESSION['users_id'])){
	header("Refresh:0; url=config");
	exit();
};

include('dbconnection.php');
include('functions.php');
$ip=get_ip();
$req='SELECT COUNT(`connection_ip`) as howManyConnection FROM `connection` WHERE `connection_datetime` > DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND `connection_success`=0 AND `connection_ip`="'.$ip.'"';
$result=mysqli_query($connect, $req);
$row = mysqli_fetch_assoc($result);
echo $row['howManyConnection'].' tentatives de connections depuis 15mins';
if ($row['howManyConnection']<11) {
	echo "<script>location.href='login';</script>";
	header('Location: login.php');
	exit();
}
?>