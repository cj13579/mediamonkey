<?php

include 'local_config.php';
$con = mysql_connect("localhost","xbmc","xbmc");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
$yesterday = date('Y-m-d',strtotime("-1 days"));
//$yesterday = '2014-04-18';

mysql_select_db("$xbmc_db_database", $con);
$new_movie_check="select $xbmc_db_database.movieview.c00, $xbmc_db_database.movieview.c01, $xbmc_db_database.movieview.c05, $xbmc_db_database.movieview.c07, $xbmc_db_database.movieview.c14 from $xbmc_db_database.movieview where $xbmc_db_database.movieview.dateAdded >= \"$yesterday%\" order by dateAdded desc limit 10;";

$new_movies = mysql_query($new_movie_check) or die(mysql_error());
$rows = mysql_num_rows($new_movies);


if( $rows > 0)
{
    $message = "<!DOCTYPE html> <html lang=\"en\">" ;
    $message .= "
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <link rel=\"shortcut icon\" href=\"../../assets/ico/favicon.ico\">

    <title>Media Monkey</title>

    <!-- Bootstrap core CSS -->
    <link href=\"http://www.cjblake.net/$uri/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Custom styles for this template -->
    <link href=\"http://www.cjblake.net/$uri/css/dashboard.css\" rel=\"stylesheet\">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src=\"../../assets/js/ie8-responsive-file-warning.js\"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
      <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
    <![endif]-->
  </head>

  <body>

	";
	$message .= "
    <!-- Body -->
    <div class=\"container-fluid\">
		<p>Hey, the following new movies are now available.</p>
		<p></p>
	<div class=\"table-responsive\">	
	<table class=\"table table-striped\">
	<tr><thead><th>Title</th><th>Description</th><th>Rating</th><th>Year</th></thead></tr>
	<tbody>
	";
		
	while($row = mysql_fetch_array($new_movies))
	{
		$title = $row['c00'];
		$desc = $row['c01'];
		$rating = floatval($row['c05']);
		$year = $row['c07'];
		//$cat = $row['c14'];
		$message .= "<tr>";
		$message .= "<td><p>$title</p></td><td><p>$desc</p></td><td><p>$rating</p></td><td><p>$year</p></td></td>";
		$message .= "</tr>";		
	} 
	
	$message .= "
	</tbody>
	</table> 
	</div>  
      	
    <!-- End Body -->      	
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
    <script src=\"http://www.cjblake.net/$uri/js/bootstrap.min.js\"></script>
    <script src=\"http://www.cjblake.net/$uri/js/docs.min.js\"></script>
  </body>
</html>
    ";
    
    //echo $message;

}
else
{
//	echo "No new movies." ;
}

if($rows > 0)
{
	//send update to subscribers
	$subscribers = "select * from $db_database.$db_table_users where movies = 1";
	$result = mysql_query($subscribers) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$user = $row['username'];
		$userinfo = posix_getpwnam("$user");
		$split = explode(",", $userinfo['gecos']);
		$userfull = $split[0];
		$split = explode(" ", $userfull);
		$userfirst = $split[0];
		//echo "$userfirst";
		$email = $row['email'];	
	
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: $userfull <$email>" . "\r\n";
		$headers .= "From: MediaMonkey <cjb.blake@gamil.com>" . "\r\n";
    	$to = "$email"; 
    	$subject = "[MediaMonkey] - There are new movies available!";
		
		//echo $headers;
		//echo "$email \n";
		
		// send mail
		if(@mail($to,$subject,$message,$headers))
		{
  			//echo "Feedback submitted.";
		}
		else
		{
 			echo "ERROR Sending Mail to $user using email $email.";
		}
	} 
}

?>
