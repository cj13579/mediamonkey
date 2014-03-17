<?php
include_once "local_config.php";
?>
<html>
<head>
 <title>TVMonkey Web Interface</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
    <div id="content">
		<table>
  			<tr>
    			<td><h3>Latest TV</h3></td><td></td><td align="right"><h3>Latest Films</h3></td>
			</tr>
			<tr>
				<td align="right" valign="top"style="line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;" >
    		<?php
			
			$con = mysql_connect("$xbmc_db_host","$xbmc_db_user","$xbmc_db_pass");
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}

			mysql_select_db("xbmc_videos75", $con);
			$sql = "SELECT ep.idEpisode, ep.idShow, ep.idSeason FROM episodeview ep ORDER BY idEpisode DESC LIMIT 5";

			$result = mysql_query($sql) or die(mysql_error());
			$rows = mysql_num_rows($result);

			while($row = mysql_fetch_array($result))
			{
				$showid = $row['idShow'];
				$epid = $row['idEpisode'];
				$seaid = $row['idSeason'];
				
				$sql2 = "SELECT tv.c00 from tvshowview tv where idShow = $showid";
				$result2 = mysql_query($sql2) or die(mysql_error());
				$rows2 = mysql_num_rows($result2);
				while($row2 = mysql_fetch_array($result2))
				{
				
				$showName = $row2['c00'];
				$showName1 = mysql_escape_string($row2['c00']);
				$sql3 = "SELECT distinct ep.c00 as epTitle, ep.c13, ep.c18, ep.dateAdded, ep.strFileName, ep.strPath, se.season FROM episodeview ep, tvshowview tv, seasons se WHERE tv.idShow and ep.idShow = $showid and tv.c00 = '$showName1' and ep.idEpisode = $epid and se.idSeason = $seaid";
				$result3 = mysql_query($sql3) or die(mysql_error());
				$rows3 = mysql_num_rows($result3);
				
					while($row3 = mysql_fetch_array($result3))
					{
				
					$eptitle = $row3['epTitle'];
					$season = $row3['season'];
					$epnum = $row3['c13'];
					$file = $row3['strFileName'];
					$str = $row3['strPath'];
					$x = "smb://Q2SERVER";
					$y = "";
					$str2 = str_replace($x, $y, $str);
					$str3 = $str2.$file;
					
					echo "<form method=\"post\" action=\"downloads.php\" target=\"_blank\" />";
					echo "$showName  | $season.$epnum  <input type=\"hidden\" name=\"dl\" value=\"1\">";
					echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
					echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
					echo "<input type=\"hidden\" name=\"type\" value=\"tvdl\">";
					echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
					/*if (preg_match("/\.(mp4)/",$file))
					{
						echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
						echo "<input type=\"hidden\" name=\"stream\" value=\"3\">";
						echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
						echo "<input type=\"hidden\" name=\"type\" value=\"tvst2\">";
						echo "<input type=\"submit\" name=\"submit\" value=\"Stream\">";
					} */
					echo "</form>";
					}
				}
			 }
			
			?>
			</td>
			<td>
			</td>
			<td valign="top" align="right" style="line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;" >
    		<?php
			
			$con = mysql_connect("localhost","xbmc","xbmc");
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}

			mysql_select_db("xbmc_videos75", $con);
			$sql = "SELECT * FROM movieview ORDER BY dateAdded DESC LIMIT 5";

			$result = mysql_query($sql) or die(mysql_error());
			$rows = mysql_num_rows($result);

			while($row = mysql_fetch_array($result))
			{
				$id = $row['idMovie'];
				$title = $row['c00'];
				$rating = round($row['c05'], 1);
				$added = $row['dateAdded'];
				$added = date("d-m-Y",strtotime($added));
				$file = $row['strFileName'];
				
				$str = $row['c22'];
				$x = "smb://Q2SERVER";
				$y = ".";
				$str2 = str_replace($x, $y, $str);
				$str3 = $str2.$file;
				
				echo "<form method=\"post\" action=\"downloads.php\" target=\"_blank\" />";
				echo "$title  ";
				echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
				echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
				echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
				echo "<input type=\"hidden\" name=\"type\" value=\"movdl\">";
				echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
				/*if (preg_match("/\.(mp4)/",$file))
				{
					echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
					echo "<input type=\"hidden\" name=\"stream\" value=\"2\">";
					echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
					echo "<input type=\"hidden\" name=\"type\" value=\"movstr2\">";
					echo "<input type=\"submit\" name=\"submit\" value=\"Stream\">";
				}*/
				echo "</form>";
			
			}	
			?>	  			
    			</td>
			</tr>
		</table>
    </div>
</div>
</body>
</html>