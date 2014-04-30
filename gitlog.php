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
	<?php
	//$out = shell_exec("git log -1 --pretty --abbrev-commit --color");
	//echo "$out";

$dir = ".";
$output = array();
chdir($dir);
exec("git log --abbrev-commit",$output);
$history = array();
foreach($output as $line){
    if(strpos($line, 'commit')===0){
	if(!empty($commit)){
	    array_push($history, $commit);	
	    unset($commit);
	}
	$commit['hash']   = substr($line, strlen('commit'));
    }
    else if(strpos($line, 'Author')===0){
	$commit['author'] = substr($line, strlen('Author:'));
    }
    else if(strpos($line, 'Date')===0){
	$commit['date']   = substr($line, strlen('Date:'));
    }
    else{		
	$commit['message']  .= $line;
    }
}
 
//print_r($history);
?>
   <table class="table" >
     <tr>
       <th></th>
       <th>Commit</th>
    <!--   <th>Author</th> -->
       <th>Date</th>
	<th>Message</th>
    </tr>
     
	<?
	$cols = 4;
    for ($row=0; $row < count($history); $row++) 
    { 
    echo "<tr>"; 
    echo "<td>".$row."</td>";
    echo "<td>".$history[$row]['hash']."</td>";
    //echo "<td>".$history[$row]['author']."</td>";
    echo "<td>".$history[$row]['date']."</td>";
    echo "<td>".$history[$row]['message']."</td>";
    

        
        /*for ($c=0; $c<$cols; $c++) 
        {
        	if ( "$" == "hash" )
        	{
        		
        	}
        } */
    echo "</tr>"; 
    }
	?>

   </table>

    <p>


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




