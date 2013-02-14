<?php

//Set variables up
$username = getenv("REMOTE_USER"); 
$download = $_POST["download"];
$id = $_POST["id"];
$date = date('Y-m-d H:i:s');

if (isset($download))
{

$con = mysql_connect("localhost","mmonkey","mmonkey");

$sql = "INSERT INTO mediamonkey.stats (user, idMovie, dttm, stat_id, type) 
VALUES ('$username', '$id', '$date','','download');";

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

?>