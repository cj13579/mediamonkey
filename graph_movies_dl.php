<?php 

session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}


$con = mysql_connect("$db_host","$db_user","$db_pass");

$sql = "SELECT count($db_database.$db_table.file) as downloads, $xbmc_db_database.movieview.strFileName, $xbmc_db_database.movieview.c00 FROM $db_database.$db_table INNER JOIN $xbmc_db_database.movieview ON $db_database.$db_table.file=xbmc_videos78.movieview.strFileName GROUP BY xbmc_videos78.movieview.c00";

$maxsql = "SELECT count($db_database.$db_table.file) as downloads, $xbmc_db_database.movieview.strFileName, $xbmc_db_database.movieview.c00 FROM $db_database.$db_table INNER JOIN $xbmc_db_database.movieview ON $db_database.$db_table.file=xbmc_videos78.movieview.strFileName GROUP BY xbmc_videos78.movieview.c00 ORDER BY downloads desc LIMIT 1";
$result = mysql_query($maxsql) or die(mysql_error());
while ( $r = mysql_fetch_array($result))
{
	$max=$r["downloads"];
}

$result = mysql_query($sql) or die(mysql_error());
$data = array();

while ( $r = mysql_fetch_array($result))
{
	$downloads=$r["downloads"];
	$title=$r["c00"];
	$data[$title]=$downloads;
}

//print_r($data);


include('phpgraphlib.php');
$graph = new PHPGraphLib(800, 600);
$graph->addData($data);
$graph->setTitle('Shows Downloaded');
$graph->setXValuesHorizontal(false);
$graph->setupXAxis(30);
$graph->setGradient('red', 'maroon');
$graph->createGraph();

?>