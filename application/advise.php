<html>
<head>
<title>Advising Center</title>
</head>
<body>
<table>
<tr><td>
<?php
include('../review/reviewFunctions.php');
include('../database.php');
$sid = $_POST['SID'];
$fid = $_GET['fid'];
echo "<table>";
printPersonal();
printAcademic();
printScores();
printPriors();
echo "<tr><td><br><br><h3>Transcripts</h3>";
$query = "select name, last_name from Personal_info where studentid=$sid";

$dbc = mysql_connect($dbServer, $dbUser,$dbPass)
    or die('Error connecting to Mysql server.');

mysql_select_db($dbName,$dbc);

$result = mysql_query($query)
    or die('students: error querying database');

$resultSet = mysql_fetch_array($result);
$fname= $resultSet['name'];
$lname = $resultSet['last_name'];
echo  '<a href="../trans.php?fname='.$fname.' &lname='.$lname.' &SID='.$sid.'"> Click to view Transcript</a>';
echo "</td></tr>";
echo "<tr><td>";

echo "</td></tr>";
echo "<form method='post' action='' >";
echo "Student Hold Status";
            echo "&emsp;&emsp;&emsp;&emsp;&emsp;";
            echo '<select name="studStatus">';
            echo '<option selected>None';
            echo '<option value ="student">Clear Hold';
	    echo '<option value ="student hold">Place Hold';
            echo "</select>";
	   echo "<input type='hidden' name='SID' value='$sid'>";
  echo '<input type="submit" value="Apply decision" name="submit"/>';

if(isset($_POST['studStatus']))
{
	if($_POST['studStatus']=='student hold')
	{
	$query = "update AcademicInfo set admitStatus='student hold' where SID=$sid";
	mysql_query($query)
	or die("error academic info update");
	
	$query = "update Personal_info set status='student hold' where studentid=$sid";
	mysql_query($query)
	or die("error personal info update");
	}
	else 
	{
		$query = "update AcademicInfo set admitStatus='student' where SID=$sid";
	mysql_query($query)
	or die("error academic info update");
	
	$query = "update Personal_info set status='student' where studentid=$sid";
	mysql_query($query)
	or die("error personal info update");
	}	
}

echo "</form>";
echo "</table>";


?>
</td></tr>
</table>

</body>
</html>
