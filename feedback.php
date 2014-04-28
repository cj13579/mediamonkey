<?php 
session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	$_SESSION['tryme'] = 1;
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}
?>

<?

$username = $_SESSION['user'];
$userfull = $_SESSION['userfull'];
$userfirst = $_SESSION['userfirst'];
$userlast = $_SESSION['userlast'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Media Monkey</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Header -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Media Monkey</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="moviemonkey.php">Movies</a></li>
            <li><a href="tvmonkey.php">TV</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          
          <!-- Search -->
          <!-- <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form> -->
          <!-- End Search -->
          
        </div>
      </div>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="container">
    
    <p>
    <p>
		<!-- Main jumbotron for a primary marketing message or call to action -->
		

		<?	
		if (!isset($_POST["submit"]))
  		{
  		?>
  		<p>Please use the form below to submit your feedback</p>
  		<div class="alert alert-info">HTML syntax is permitted.</div>
		<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
			<input type="text" class="form-control" placeholder="Subject" name="subject">
			<br />
			<textarea class="form-control" rows="3" name="message" placeholder="Message"></textarea>
		<br />
		<button type="submit" name="submit" class="btn btn-default">Submit</button>
		<button type="submit" name="cancel" class="btn btn-default">Cancel</button>
		</form>
  		<?php 
  		}
		else
  		// the user has submitted the form
  		{
  		
  		if (isset($_POST["cancel"])){	header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
	exit;}
  		
  		// Check if the "from" input field is filled out
  		if (isset($_POST["message"]))
    		{
    		
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
			$headers .= 'To: MediaMonkey-Feedback <cjb.blake@gmail.com>' . "\r\n";
			$headers .= "From: $userfull <cjb.blake@gamil.com>" . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
    		//$to = $_POST["to"]; // sender
    		$to = "cjb.blake@gmail.com"; // sender
    		//$from = $_POST["from"]; // sender
    		$subject = $_POST["subject"];
    		$text = $_POST["message"];
    		$message = "
    		<html>
    		<head>
    			    <meta charset=\"utf-8\">
    				<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    				<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    				<meta name=\"description\" content=\"\">
    				<meta name=\"author\" content=\"\">
    		   		<link href=\"http://$_SERVER[SERVER_NAME]/$uri/css/bootstrap.min.css\" rel=\"stylesheet\">
    				<link href=\"http://$_SERVER[SERVER_NAME]/$uri/css/dashboard.css\" rel=\"stylesheet\">
    		</head>
  			<body>
  			
    		<div class=\"container\">
    			<p>$text</p>
  			</div>
  				
  			</body>
  			</html>
    		
    		" ;
    		// message lines should not exceed 70 characters (PHP rule), so wrap it
    		//$message = wordwrap($message, 70);
    		// send mail
    		if(@mail($to,$subject,$message,$headers))
				{
  					echo "<div class=\"alert alert-success\">Feedback submitted.</div>";
  					echo "<p><a href=\"profile.php\">Back to profile</a></p>";
				}
				else
				{
 					 echo "<div class=\"alert alert-danger\">Mail did not send. Try again later.</div>";
				}
    		}
  		}
  		?>
  			
  	
  	
    </div>
    <!-- End Body -->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/docs.min.js"></script>
  </body>
</html>



