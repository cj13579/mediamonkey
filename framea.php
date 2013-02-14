<?php
$username = getenv("REMOTE_USER"); 
$string = shell_exec("grep $username /etc/passwd");
$array1 = explode(":", $string);
$string2 = $array1[4];
$array2 = explode(",",$string2);
$fullname = $array2[0];
?>
<html>
<head>
 <title>TVMonkey Web Interface</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" type="text/css" href="stylea.css" />
</head>
<body>
<div id="container">
    <div id="logo">
		<h1><span class="blue">Media</span>Monkey</h1>
	</div>
<p>
<p>
<p>User: <?php echo $fullname; ?>
</div>
</body>
</html>
