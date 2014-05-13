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
    <div class="container-fluid">
		<!-- Main jumbotron for a primary marketing message or call to action -->
<?php
    $con = mysql_connect("localhost","xbmc","xbmc");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    
    //set limit for number or results
    $rc=30;
    
    
    mysql_select_db("$xbmc_db_database", $con);
    $sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c07, movie.c14, movie.c22 FROM art, movie WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'poster' ORDER BY movie.c00";
    
    $result = mysql_query($sql) or die(mysql_error());
    //count results
    $rows = mysql_num_rows($result);
    
    //calculate last page
    $last = ceil($rows/$rc);
    
    //check if page number is set
    $pagenum = $_GET['pagenum'];
    
    if (!(isset($pagenum)))
    {
        $pagenum = 1;
    }
    if ($pagenum < 1)
    {
        $pagenum = 1;
    }
    elseif ($pagenum > $last)
    {
        $pagenum = $last;
    }
    
	
    $max = 'LIMIT ' .($pagenum - 1) * $rc .',' .$rc;
    //$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c07, movie.c14, movie.c22 FROM art, movie WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'poster' ORDER BY movie.c00 $max";
    
    $sql = "SELECT * FROM movieview ORDER BY movieview.c00 $max";
    
    $result = mysql_query($sql) or die(mysql_error());
    $rows = mysql_num_rows($result);
?>

          <!-- <h2 class="sub-header">Section title</h2> -->
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <!-- <th>#</th> -->
                  <th>Title</th>
                  <th>IMDB Rating</th>
                  <th>Description</th>
                  <th>Release Year</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>

<?php
    
    $per_row=1;
    $split=0;
	
	while($row = mysql_fetch_array($result))
	{
		$id = $row['idMovie'];
		$title = $row['c00'];
		$score = floatval($row['c05']);
		$rating = $row['c12'];
		$src = $row['url'];
		$desc = $row['c03'];
		$year = $row['c07'];
		
		//echo "<td>";
		echo "<td><p>$title</td>";
		echo "<td align=center><p>$score</td>";
		//echo "<td>";
		//$path = _get_hash($src);
		//$x = substr($path, 0, 1);
		//$array = array("$x", "$path");
		//$path = implode("/",$array);
		//echo "<a href='moviedetails.php?id=$id'>Details</a>";
		
		echo "<td><p>$desc</td>";
		
		echo "<td align=center><p>$year</td>";
		echo "<td valign=center>";
		echo "<form role=\"form\" method='get' action='moviedetails.php'>";
		echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
		//echo "<input type=\"submit\" name=\"submit\" value=\"".$title."\">";
		echo "<button type=\"submit\" name=\"submit\" class=\"btn btn-link\">Details</button>";
		echo "</form>";
		echo "</td>";
		
		$split++;
		if ($split%$per_row==0){
			echo '</tr><tr>';
		}
	}

    
?>
              </tbody>
            </table>
            
            
            
		<div class="container-fluid" align="center">
<?php
    
    // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
    
    if ($pagenum == 1)
    {
        echo "<p>--Page $pagenum of $last-- ";
        $next = $pagenum+1;
        // This shows the user what page they are on, and the total number of pages
        echo "<a href='{$_SERVER['PHP_SELF']}?pagenum=$next' class=\"btn btn-default\" role=\"button\">Next </a> ";
        echo " ";
        echo " <td><a href='{$_SERVER['PHP_SELF']}?pagenum=$last' class=\"btn btn-default\" role=\"button\">Last </a></p> ";
    }
    elseif ($pagenum == $last)
    {
        echo "<p><a href='{$_SERVER['PHP_SELF']}?pagenum=1' class=\"btn btn-default\" role=\"button\"> First</a> ";
        echo " ";
        $previous = $pagenum-1;
        echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous' class=\"btn btn-default\" role=\"button\"> Previous</a> ";
        echo "--Page $pagenum of $last-- </p>";
    }
    else
    {
        $next = $pagenum+1;
        echo "<p><a href='{$_SERVER['PHP_SELF']}?pagenum=1' class=\"btn btn-default\" role=\"button\"> First</a> ";
        echo " ";
        $previous = $pagenum-1;
        echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous' class=\"btn btn-default\" role=\"button\"> Previous</a> ";
        // This shows the user what page they are on, and the total number of pages
        echo "--Page $pagenum of $last-- ";
        echo "<a href='{$_SERVER['PHP_SELF']}?pagenum=$next' class=\"btn btn-default\" role=\"button\">Next </a> ";
        echo " ";
        echo " <td><a href='{$_SERVER['PHP_SELF']}?pagenum=$last' class=\"btn btn-default\" role=\"button\">Last </a></p> ";
    } 
    
    ?>
    	</div>
    	
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

