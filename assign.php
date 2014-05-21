<html>
<h1>DONE</h1>


<?php
include ("database.php");

$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use


$CID = $_POST['course'];//getting the info from the course id represented in a hidden variable in course.php
$fname = $_POST['fname'];//getting the info from the First Name variable
$lname = $_POST['lname'];//getting the info from the Last Name variable
$PID = $_POST['password'];//getting the info from the Password variable


$result = mysql_query("SELECT COUNT(SID) FROM enrolled");//SQL query to count all the Students IDs on the course
$count = mysql_fetch_array($result);//variable 'count' that represent the value of the previous query
$x = 1;
$CID= $_POST['cid'];//getting the info from the cid hidden variable in grades obtained from the selected course
$length = $_POST['length'];//variable that holds the info from a hidden variable in grades that possesses how many students are in the class

while ($x < $count[0] +1 ){//while loop to go through every student and update their grades respectively
    $in = $_REQUEST['num'.$x.''];
	$i = $_REQUEST['grade'.$in];
	$n = "";
    if ($i != "---"){//if statement, if the value in the dropdown menu is not nothing then update the table enrolled.
		mysql_query("UPDATE enrolled SET grade = '".$i."' WHERE ".$in." = enrolled.SID AND $CID = enrolled.CID")//SQL query to update the grades column in the table enrolled depending on student and class
		or die("Error Running query");
		
		//comparing each letter grade assign to equal them to the corresponding GPA 
		if($i == 'A'){
		$n = '4.0';
		}
		if($i == 'A-'){
		$n = '3.7';
		}
		if($i == 'B+'){
		$n = '3.3';
		}
		if($i == 'B'){
		$n = '3.0';
		}
		if($i == 'B-'){
		$n = '2.7';
		}
		if($i == 'C+'){
		$n = '2.3';
		}
		if($i == 'C'){
		$n = '2.0';
		}
		if($i == 'F'){
		$n = '0.0';
		}
	
		mysql_query("UPDATE enrolled SET gpa = '".$n."' WHERE ".$in." = enrolled.SID AND $CID = enrolled.CID")//SQL query to update the gpa column in the table enrolled depending on student and class
		or die("Error Running query");
		
		$x++;
	}
}

//back button to go to grades from assign
echo " <form action='grades.php' method='post'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<input type='hidden' name='password' value='".$PID."'>
<input type='hidden' name='course' value='".$CID."'>
<td><td><input type='submit' value='Back'></td></td>
</form>";


mysql_close($dbc);//closing sql database connection

?>
</html>
