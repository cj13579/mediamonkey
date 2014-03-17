<?php

include_once "local_config.php";

//Set variables up
$username = getenv("REMOTE_USER"); 
$download = $_POST["download"];
$dl = $_POST["dl"];
//$stream = $_POST["stream"];
$med_type = $_POST["type"];
$id = $_POST["id"];
$date = date('Y-m-d H:i:s');
$file = $_POST['file'];
$host = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'];

# CUSTOM VARIBALE
$uri = "";

if(is_null($file))
{
	$type = "library";
	$file = "$file";
}
else
{
	$type = "files";
}

if (isset($dl))
{

$con = mysql_connect("$db_host","$db_user","$db_pass");

$sql = "INSERT INTO $db_database.$db_table (user, idMovie, dttm, stat_id, type, file, med_type) 
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


/*
if ($stream == "1")
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
header("location:http://$host:$port/$download");
}
else
{
header("location:http://$host:$port/$uri/$download");
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
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$host:$port/$download\">";
}
else
{
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$host:$port/$uri/$download\">";
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
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$host:$port$download\">";
}
else
{
echo "<META http-equiv=\"refresh\" content=\"1;URL=http://$host:$port/$uri$download\">";
}

}
*/
?>
