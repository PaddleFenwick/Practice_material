<html>
<head>
<title>Graduate Admission Review Form</title>
</head>
<body>
<?php
//include databse login info
include("../database.php");
#include("/var/www/apps/reviewFunctions.php"); 
include("studentFunctions.php");
$sid = $_GET['sid'];
$stat = $_GET['stat'];
echo "<h2>Graduate Admission Application</h2>";
echo "<table border='1'>";
echo "<tr><td>";
echo 'Applicant Student ID &emsp;<select name="SID">';
echo "<option value='$sid'>$sid</option></select>";
echo "&emsp; &emsp;&emsp;&emsp;&emsp;";
echo "</td></tr>";
$transcriptStat = "unreceived";
$recStat = "unreceived";
//prints out students name and student id
printPersonal();
printAcademic();
printScores();
printPriors();
printStatus();
printAppStatus();
echo "</table>";
printPasswordChange();
echo "<br><br><a href='start.html'>Click to log out</a>";
?>

 
</body>
</html>
