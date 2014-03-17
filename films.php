<?php

if(isset($_GET['prev_direc']))
{
	$directory = $_GET['prev_direc'];
}

if(isset($_POST['directory']))
{
	$directory = $_POST['directory'];
	$prev_direc = $_POST['prev_direc'];
}

?>

<html>
<head>
 <title>Films</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
    <div id="content">
		<div id="home" name="home1" >
			
			<?php
			
			if(!isset($directory))
			{
				$directory = 'Films';
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));		
				echo "<table>";
				echo "<tr>";
				echo "<td><b>Directory/File Name</td><td></td><td></td>";
				echo "</tr>";
				foreach ($scanned_dir as $value) 
				{
					if (is_dir("$directory/$value"))
					{
						$a = "$directory/$value";
						#echo "Directory : $value <br>";
						echo "<tr>";
						echo "<td>";
							echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" />";
							echo "<input type=\"hidden\" name=\"directory\" value=\"".$a."\">";
							echo "<input type=\"hidden\" name=\"prev_direc\" value=\"Films\">";
							echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
							echo "</form>";
						echo "</td>";
						echo "</tr>";
						#echo "<a href=\"$directory/$value\">$value</a>	<br>";
					}
					else
					{
						#echo "File : $value <br>";
					}
				}
				echo "</table>";
			}
			else
			{
				$directory = "$directory";
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));	
				echo "<table>";	
				echo "<tr>";
				if(isset($prev_direc))
				{
					echo "<td><b>Back to: <a href=\"films.php?prev_direc=$prev_direc\">$prev_direc</a></td><td></td><td></td>";
				}
				echo "</tr>";
				echo "<tr>";
				echo "<td><b>Directory/File Name</td><td></td><td></td>";
				echo "</tr>";
				foreach ($scanned_dir as $value) 
				{
					if (is_dir("$directory/$value"))
					{
						$a = "$directory/$value";
						#echo "Directory : $value <br>";
						echo "<tr>";
						echo "<td>";
							echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" />";
							echo "<input type=\"hidden\" name=\"directory\" value=\"".$a."\">";
							echo "<input type=\"hidden\" name=\"prev_direc\" value=\"".$directory."\">";
							echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
							echo "</form>";
						echo "</td>";
						echo "</tr>";
						#echo "<a href=\"$directory/$value\">$value</a>	<br>";
					}
					else
					{
						if (preg_match("/\.(avi|mp4|mkv|m4v)/",$value))
						{
							$b = "$directory/$value";
							echo "<table style=\"vertical-align:bottom\">";
							echo "<tr>";
							echo "<td valign=\"bottom\">";
								echo "$value";
							echo "</td>";
							echo "<td>";
								//echo "<p>";
								echo "<form method=\"post\" action=\"downloads.php\" />";
								echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
								echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
								echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
								echo "<input type=\"hidden\" name=\"type\" value=\"movdl\">";
								echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
								echo "</form>";
							echo "</td>";
							echo "<td></td>";
							if (preg_match("/\.(mp4)/",$value))
							{
								echo "<td>";
									//echo "<p>";
									echo "<form method=\"post\" action=\"downloads.php\" />";
									echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
									echo "<input type=\"hidden\" name=\"stream\" value=\"1\">";
									echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
									echo "<input type=\"hidden\" name=\"type\" value=\"movs1\">";
									echo "<input type=\"submit\" name=\"submit\" value=\"Stream (inline)\">";
									echo "</form>";
								echo "</td>";
							}
							if (preg_match("/\.(mp4)/",$value))
							{
								echo "<td>";
									//echo "<p>";
									echo "<form method=\"post\" action=\"downloads.php\" target=\"_blank\"/>";
									echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
									echo "<input type=\"hidden\" name=\"stream\" value=\"2\">";
									echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
									echo "<input type=\"hidden\" name=\"type\" value=\"movst2\">";
									echo "<input type=\"submit\" name=\"submit\" value=\"Stream (new window)\">";
									echo "</form>";
								echo "</td>";
							}
							echo "</tr>";						
						}
					}
				}
				echo "</table>";
			}
			?>
		</div>
    </div>
    <div class="br"></div>
</div>
</body>
</html>

