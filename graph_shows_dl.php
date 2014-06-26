<?php 

session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}


$con = mysql_connect("$db_host","$db_user","$db_pass");
$sql = "SELECT count(showid) as downloads, showname FROM $db_database.$db_table WHERE showid > 0 GROUP BY showid";
$result = mysql_query($sql) or die(mysql_error());
$data = array();

while ( $r = mysql_fetch_array($result))
{
	$downloads=$r["downloads"];
	$showname=$r["showname"];
	$data[$showname]=$downloads;
}

//print_r($data);


include('phpgraphlib.php');
$graph = new PHPGraphLib(500, 350);
$graph->addData($data);
$graph->setTitle('Shows Downloaded');
$graph->setXValuesHorizontal(true);
$graph->setGradient('red', 'maroon');
$graph->createGraph();



?>