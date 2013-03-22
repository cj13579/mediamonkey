<?php

if(isset($_POST['directory']))
{
	$directory = $_POST['directory'];
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
			<p>
			<?php
			
			if(!isset($directory))
			{
				$directory = 'Films';
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));		
				foreach ($scanned_dir as $value) 
				{
					if (is_dir("$directory/$value"))
					{
						$a = "$directory/$value";
						#echo "Directory : $value <br>";
						echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" />";
						echo "<input type=\"hidden\" name=\"directory\" value=\"".$a."\">";
						echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
						echo "</form>";
						#echo "<a href=\"$directory/$value\">$value</a>	<br>";
					}
					else
					{
						#echo "File : $value <br>";
					}
				}
			}
			else
			{
				$directory = "$directory";
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));		
				foreach ($scanned_dir as $value) 
				{
					if (is_dir("$directory/$value"))
					{
						$a = "$directory/$value";
						#echo "Directory : $value <br>";
						echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" />";
						echo "<input type=\"hidden\" name=\"directory\" value=\"".$a."\">";
						echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
						echo "</form>";
						#echo "<a href=\"$directory/$value\">$value</a>	<br>";
					}
					else
					{
						if (preg_match("/\.(avi|mp4|mkv|m4v)/",$value))
						{
							echo "<p>";
							echo "To download this file, click the button:";
							echo "<p>";
							$b = "$directory/$value";
							echo "<form method=\"post\" action=\"downloads.php\" />";
							echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
							echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
							echo "<input type=\"hidden\" name=\"type\" value=\"movie\">";
							echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
							echo "</form>";
							echo "<p>";
						}
					}
				}
			}
			?>
		</div>
    </div>
    <div class="br"></div>
</div>
</body>
</html>

