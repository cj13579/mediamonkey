<?php
include_once "local_config.php";

if(isset($_POST['terms']))
{
	$terms = $_POST['terms'];
}

$user = getenv("REMOTE_USER"); 
?>
<html>
 <title>MediaMonkey Web Interface</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
<div id="container">
    <div id="content">

<?php

if(isset($terms))
{
	$type=$_POST['type'];
	$title=$_POST['title'];
	$additional=$_POST['additional'];
	$link=$result;
	$summary=$_POST['summary'];
	$severity=$_POST['severity'];
	$rep=$_POST['rep'];
	$desc=$_POST['desc'];

$c = new SoapClient("http://cj13579.dyndns-server.com/mantis/api/soap/mantisconnect.php?wsdl");
     $username = "$mantis_username";
     $password = "$mantis_password";
     $issue = array ( 
        "category" =>"$type",
		"reproducibility" => "$rep",
		"severity" => "$severity",
		"name" => "mediamonkey",
		"project"=>array('id'=>4), 
		"priority" => "normal",
		"summary" => "$summary", 
        "description" => "$desc", 
		"additional_information" => "$additional - submitted by $user",
		"status" => "private"
					);
$result=$c->mc_issue_add($username, $password, $issue);

if(isset($result))
{
	$link=$result;
	echo "<p>Request $request sucessfully submitted. You can see the status of your request <a href=\"http://cj13579.dyndns-server.com/mantis/view.php?id=$link\">here</a>. ";   
    echo "<p>";
	echo "<table>";
	echo "<tr>";
	echo "<td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">";
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" name=\"finder\">";
    echo "<br>";
    echo "<b>Type: </b><input type=\"radio\" name=\"severity\" value=\"feature\"> Feature <input type=\"radio\" name=\"severity\" value=\"minor\"> Bug <br>";
    echo "<b>Location: </b><input type=\"radio\" name=\"type\" value=\"Application\"> Application <input type=\"radio\" name=\"type\" value=\"Web Site\"> Web Site <br>";
	echo "<br>";
	echo "<br>";
	echo "<b>Reproducibility: </b><input type=\"radio\" name=\"rep\" value=\"sometimes\"> Sometimes <input type=\"radio\" name=\"rep\" value=\"always\"> Web Always  <input type=\"radio\" name=\"rep\" value=\"N/A\"> N/A <br>";
	echo "<br>";
	echo "<br>";
	echo "<b>Summary: </b><input type=\"text\" name=\"summary\">";
	echo "<br>";
	echo "<br>";
	echo "<b>Description: </b><input type=\"text\" name=\"desc\">";
	echo "<br>";
	echo "<br>";
	echo "<b>Additional Information: </b><input type=\"text\" name=\"additional\"><br>";
    echo "<input type=\"submit\" name=\"terms\" value=\"Submit\"> Be patient when you press submit - it will be doing something!";  
	echo "</td>";
    echo "</form>";
	echo "</tr>";
	echo "</tr>";
	echo "</table>";
    echo "<p><p><p><p><p><p><p>";

}
else
{
	echo "<p> Request not submitted successfully, please try again:";
    echo "<p>";
	echo "<table>";
	echo "<tr>";
	echo "<td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">";
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" name=\"finder\">";
    echo "<br>";
    echo "<b>Type: </b><input type=\"radio\" name=\"severity\" value=\"feature\"> Feature <input type=\"radio\" name=\"severity\" value=\"minor\"> Bug <br>";
    echo "<b>Location: </b><input type=\"radio\" name=\"type\" value=\"Application\"> Application <input type=\"radio\" name=\"type\" value=\"Web Site\"> Web Site <br>";
	echo "<br>";
	echo "<br>";
	echo "<b>Reproducibility: </b><input type=\"radio\" name=\"rep\" value=\"sometimes\"> Sometimes <input type=\"radio\" name=\"rep\" value=\"always\"> Web Always  <input type=\"radio\" name=\"rep\" value=\"N/A\"> N/A <br>";
	echo "<br>";
	echo "<br>";
	echo "<b>Summary: </b><input type=\"text\" name=\"summary\">";
	echo "<br>";
	echo "<br>";
	echo "<b>Description: </b><input type=\"text\" name=\"desc\">";
	echo "<br>";
	echo "<br>";
	echo "<b>Additional Information: </b><input type=\"text\" name=\"additional\"><br>";
    echo "<input type=\"submit\" name=\"terms\" value=\"Submit\"> Be patient when you press submit - it will be doing something!";  
	echo "</td>";
    echo "</form>";
	echo "</tr>";
	echo "</tr>";
	echo "</table>";
    echo "<p><p><p><p><p><p><p>";
}

}
else
{
	echo "<p> Use the form below to register your feature request or bug:";
    echo "<p>";
	echo "<table>";
	echo "<tr>";
	echo "<td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">";
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" name=\"finder\">";
    echo "<br>";
    echo "<b>Type: </b><input type=\"radio\" name=\"severity\" value=\"feature\"> Feature <input type=\"radio\" name=\"severity\" value=\"minor\"> Bug <br>";
    echo "<b>Location: </b><input type=\"radio\" name=\"type\" value=\"Application\"> Application <input type=\"radio\" name=\"type\" value=\"Web Site\"> Web Site <br>";
	echo "<br>";
	echo "<br>";
	echo "<b>Reproducibility: </b><input type=\"radio\" name=\"rep\" value=\"sometimes\"> Sometimes <input type=\"radio\" name=\"rep\" value=\"always\"> Web Always  <input type=\"radio\" name=\"rep\" value=\"N/A\"> N/A <br>";
	echo "<br>";
	echo "<br>";
	echo "<b>Summary: </b><input type=\"text\" name=\"summary\">";
	echo "<br>";
	echo "<br>";
	echo "<b>Description: </b><input type=\"text\" name=\"desc\">";
	echo "<br>";
	echo "<br>";
	echo "<b>Additional Information: </b><input type=\"text\" name=\"additional\"><br>";
    echo "<input type=\"submit\" name=\"terms\" value=\"Submit\"> Be patient when you press submit - it will be doing something! A link to your request, so that you can track it, will appear at the top of the page when the request has been processed.";  
	echo "</td>";
    echo "</form>";
	echo "</tr>";
	echo "</tr>";
	echo "</table>";
    echo "<p><p><p><p><p><p><p>";
}

?>



	</div>
	</div>
</div>
</body>

</html>