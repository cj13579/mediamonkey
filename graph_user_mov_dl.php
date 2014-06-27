<?php 

session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}

if(isset($_GET['user'])){$username = $_GET["user"];}

$con = mysql_connect("$db_host","$db_user","$db_pass");
$sql = "select (select count(med_type) from $db_database.$db_table where med_type = \"tvdl\" and user = \"$username\") as shows,
		(select count(med_type) from $db_database.$db_table where med_type = \"movdl\" and user = \"$username\") as movies";
$result = mysql_query($sql) or die(mysql_error());
$data = array();

while ( $r = mysql_fetch_array($result))
{
	$data[TV]=$r["shows"];
	$data[Movies]=$r["movies"];
}

//print_r($data1);
//$data2 = array("Movies" => 16, "TV" => 10);
//print_r($data2);


include('phpgraphlib.php');
include('phpgraphlib_pie.php');
$graph = new PHPGraphLibPie(500, 350);
$graph->addData($data);
$graph->setTitle('% TV Shows vs Movies you\'ve downloaded');
$graph->setLabelTextColor('50,50,50');
$graph->setLegendTextColor('50,50,50');
$graph->createGraph();


?>