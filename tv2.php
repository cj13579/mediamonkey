<?php

if(isset($_POST['directory']))
{
	$directory = $_POST['directory'];
}

?>

<html>
<head>
 <title>TV2</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
    <div id="content">
		<div id="home" name="home1" >
			<p>
			<p> Use the buttons to navigate through the folders. When you get to the files you will be able to download them using the link. If the file is MP4 2 streaming options will be available to watch straight from your browser however this only works on some browsers.
			<p>
			<?php
			
			if(!isset($directory))
			{
				$directory = 'TV2';
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));		
				echo "<table>";
				echo "<tr>";
				echo "<td><p><b>Directory/File Name</td><td></td><td></td>";
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
				echo "<td><p><b>Directory/File Name</td><td></td><td></td>";
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
								echo "<p>$value";
							echo "</td>";
							echo "<td>";
								echo "<p>";
								echo "<form method=\"post\" action=\"downloads.php\" />";
								echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
								echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
								echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
								echo "<input type=\"hidden\" name=\"type\" value=\"tvdl\">";
								echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
								echo "</form>";
							echo "</td>";
							echo "<td></td>";
							if (preg_match("/\.(mp4)/",$value))
							{
								echo "<td>";
									echo "<p>";
									echo "<form method=\"post\" action=\"downloads.php\" />";
									echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
									echo "<input type=\"hidden\" name=\"stream\" value=\"1\">";
									echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
									echo "<input type=\"hidden\" name=\"type\" value=\"tvst1\">";
									echo "<input type=\"submit\" name=\"submit\" value=\"Stream (inline)\">";
									echo "</form>";
								echo "</td>";
							}
							if (preg_match("/\.(mp4)/",$value))
							{
								echo "<td>";
									echo "<p>";
									echo "<form method=\"post\" action=\"downloads.php\" target=\"_blank\"/>";
									echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
									echo "<input type=\"hidden\" name=\"stream\" value=\"2\">";
									echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
									echo "<input type=\"hidden\" name=\"type\" value=\"tvst2\">";
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