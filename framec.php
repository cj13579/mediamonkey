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
		<div id="home" name="home1" >
			<p>
			
			<table>

  			<tr>
    			<td width="220px" valign="top"><h3>Latest TV</h3>
    			<p><strong> Show | Season.Episode </strong>
    		<?php
			
			$con = mysql_connect("localhost","xbmc","xbmc");
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
				$sql3 = "SELECT distinct ep.c00 as epTitle, ep.c13, ep.c18, ep.dateAdded, ep.strFileName, ep.strPath, se.season FROM episodeview ep, tvshowview tv, seasons se WHERE tv.idShow and ep.idShow = $showid and tv.c00 = '$showName' and ep.idEpisode = $epid and se.idSeason = $seaid";
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
					echo "<p>";
					echo "$showName  | ";
					echo "$season.$epnum  <br />";
					echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
					echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
					echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
					echo "<input type=\"hidden\" name=\"type\" value=\"tvdl\">";
					echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
					if (preg_match("/\.(mp4)/",$file))
					{
						echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
						echo "<input type=\"hidden\" name=\"stream\" value=\"3\">";
						echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
						echo "<input type=\"hidden\" name=\"type\" value=\"tvst2\">";
						echo "<input type=\"submit\" name=\"submit\" value=\"Stream\">";
					}
					echo "</form>";
					}
				}
			 }
			
			?>
    				
    			</td>
    			<td rowspan="2" valign="top">
 			<h3>Blog</h3>
 			<p> <strong>22/03/2013 - </strong>Version 0.2 of MediaMonkey is up. A raft of changes in this version that should make everything lovely but most of the changes are around performance and statistics collection in the back end which aren't, unless you are a geek, particularly interesting. However, there are a couple on the functionality front that I'll go over:
			
			<p><b>look and feel</b>
			<br />The main change that you will notice is with the "tv","tv2" and "films" links. They were the only sections didn't have the same look and feel as the rest of the site. This has now been sorted so the site should look and feel consistent throughout.
			<p><b>speedy gonzalez</b>
			<br />The other thing about the "tv","tv2" and "films" sections was that not only did they look rubbish but their performance was awful. This should now be significantly better than it was. It may still take up to 5/10 seconds if you are hitting the "tv2" or "films" links as the drive needs to spin up. I'm Green inside.
			<p><b>the choice is yours</b>
			<br />The final change is that I have added (where the files are compatible) stream options to all TV shows and Films. If the file type is compatible for viewing straight in the browser then you will get two options:
			<br />
			<br /> - Inline Streaming - This opens up the video in the same window.
			<br /> - New Window Streaming - As it says on the tin, this opens the video in a new window.
			<p>
			<p>-------------------------------------------------------
			<p>
			<p>
			<p><strong>05/02/2013 - </strong>Welcome to Media Monkey. I hope you find it an improvement on the previous interface to my movies and TV. At the moment only the Movies section is fully working with the new look and while there is a "library" view available for TV you can't download anything through it yet. Don't fear though, you can us the "tv" and "tv2" links as of old to get all available TV episodes.
			
			<p>I don't know whether or not any of you do but for quite a few of the TV episodes and a few of the movies you can stream them straight from your browser (Chrome works the best). The files need to be MP4. If you want to do that with any of the films then you will need to use the "films" menu which will take you to the familiar boring site. The library mode will force you to download the file.
			
			<p>Although I have tested downloading a few movies there is a chance that some stuff doesn't work. So, please let me know if anything is broken and I'll do my best to get it sorted for you ASAP.
			<p> Ta, Chris.   			
    			
    			
    			
    			</td>
  			</tr>
  			<tr>
    			<td valign="top"><h3>Latest Films</h3>
    		
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
				echo "<p>";
				echo "$title  <br />";
				echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
				echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
				echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
				echo "<input type=\"hidden\" name=\"type\" value=\"movdl\">";
				echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
				if (preg_match("/\.(mp4)/",$file))
				{
					echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
					echo "<input type=\"hidden\" name=\"stream\" value=\"2\">";
					echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
					echo "<input type=\"hidden\" name=\"type\" value=\"movstr2\">";
					echo "<input type=\"submit\" name=\"submit\" value=\"Stream\">";
				}
				echo "</form>";
			
			}	
			?>	
    			
    			
    			</td>
  			</tr>
			</table>	

		</div>
    </div>
    <div class="br"></div>
</div>
</body>
</html>

