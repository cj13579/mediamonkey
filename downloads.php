<?php 
session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	$_SESSION['tryme'] = 1;
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}


//Set variables up
$username = $_SESSION["user"]; 
$password = $_SESSION["password"];
if(isset($_POST['download'])){$download = $_POST["download"];}
if(isset($_POST['dl'])){$dl = $_POST["dl"];}
if(isset($_POST['stream'])){$stream = $_POST["stream"];}
if(isset($_POST['type'])){$med_type = $_POST["type"];}
if(isset($_POST['id'])){$id = $_POST["id"];}

if(isset($_POST['showid'])){$showid = $_POST["showid"];}
if(isset($_POST['epid'])){$epid = $_POST["epid"];}
if(isset($_POST['season'])){$season = $_POST["season"];}
if(isset($_POST['title'])){$title = $_POST["title"];}
if(isset($_POST['showname'])){$showname = $_POST["showname"];}

$date = date('Y-m-d H:i:s');
if(isset($_POST['file'])){$file = $_POST['file'];}
$host = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'];


if(is_null($file))
{
	$type = "library";
	$file = "$id";
}
else
{
	$type = "files";
}

if (isset($dl))
{

$con = mysql_connect("$db_host","$db_user","$db_pass");

//used to seperate tv from movie downloads



if ( "$med_type" == "tvdl" )
{
//echo "this is a tv show";
$sql = "INSERT INTO $db_database.$db_table (user, idMovie, dttm, stat_id, type, file, med_type, showid, epid, title, showname) 
VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type', '$showid', '$epid', '$title', '$showname');";
}
if ( "$med_type" == "movdl" )
{
//echo "this is not a tv show";
$sql = "INSERT INTO $db_database.$db_table (user, idMovie, dttm, stat_id, type, file, med_type) 
VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";
}

if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}


if (file_exists($download)) {
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".basename($download));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: " . filesize($download));
    ob_clean();
    flush();
    readfile($download);
    exit;
    }

}


if(isset($stream))
{

if ($stream == "1")
{

$con = mysql_connect("$db_host","$db_user","$db_pass");


$sql = "INSERT INTO $db_database.$db_table (user, idMovie, dttm, stat_id, type, file, med_type) VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";

if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}

if(is_null($uri))
{
header("location:http://$username:$password@$host:$port/$download");
}
else
{
header("location:http://$username:$password@$host:$port/$uri/$download");
}

}

if ($stream == "2" )
{

$con = mysql_connect("$db_host","$db_user","$db_pass");


$sql = "INSERT INTO $db_database.$db_table (user, idMovie, dttm, stat_id, type, file, med_type) 

VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";

if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}

if(is_null($uri))
{
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$username:$password@$host:$port/$download\">";
}
else
{
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$username:$password@$host:$port/$uri/$download\">";
}

}

if ($stream == "3" )
{

$con = mysql_connect("$db_host","$db_user","$db_pass");

$sql = "INSERT INTO $db_database.$db_table (user, idMovie, dttm, stat_id, type, file, med_type) 
VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";

if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}

if(is_null($uri))
{
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$username:$password@$host:$port$download\">";
}
else
{
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$username:$password@$host:$port/$uri$download\">";
}

}

}

?>
