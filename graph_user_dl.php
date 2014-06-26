<?php 

session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}


$con = mysql_connect("$db_host","$db_user","$db_pass");
$sql = "SELECT COUNT(user) as downloads, user FROM $db_database.$db_table GROUP BY user";
$result = mysql_query($sql) or die(mysql_error());
$data = array();

while ( $r = mysql_fetch_array($result))
{
	$downloads=$r["downloads"];
	$user=$r["user"];
	$data[$user]=$downloads;
}

//print_r($data);


include('phpgraphlib.php');
$graph = new PHPGraphLib(500, 350);
$graph->addData($data);
$graph->setTitle('User Downloads');
$graph->setXValuesHorizontal(true);
$graph->setGradient('red', 'maroon');
$graph->createGraph();



?>