<?php

//Set variables up
$username = getenv("REMOTE_USER"); 
$download = $_POST["download"];
$stream = $_POST["stream"];
$med_type = $_POST["type"];
$id = $_POST["id"];
$date = date('Y-m-d H:i:s');
$file = $_POST['file'];
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

$con = mysql_connect("localhost","mmonkey","mmonkey");

$sql = "INSERT INTO mediamonkey.stats_test (user, idMovie, dttm, stat_id, type, file, med_type) 
VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";

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

if ($stream == "1")
{

$con = mysql_connect("localhost","mmonkey","mmonkey");

$sql = "INSERT INTO mediamonkey.stats_test (user, idMovie, dttm, stat_id, type, file, med_type) 
VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";

if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}
header("location:http://$host:$port/$download");

}

if ($stream == "2" )
{

$con = mysql_connect("localhost","mmonkey","mmonkey");

$sql = "INSERT INTO mediamonkey.stats_test (user, idMovie, dttm, stat_id, type, file, med_type) 
VALUES ('$username', '$id', '$date','','$type', '$file', '$med_type');";

if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}

echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$host:$port/$download\">";
}

?>