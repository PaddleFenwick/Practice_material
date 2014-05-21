<html>
<head></head>
<body>
<h2>COURSE REGISTRATION</h2>


<?php
  include ("database.php");
  $fname = $_POST['fname'];//retrieve the info from the First Name input
  $lname = $_POST['lname'];//retrieve the info from the Last Name input
  $SID = $_POST['SID'];//retrieve the info from the SID input
  $semester = $_POST['semester'];//retrieve the info from the semester input
  $year = '2013';

//determine if a student has chosen a course to register for
//if not, return error
	if (!(isset($semester))) {
			echo " <form action='enroll11.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='submit' value='Back'>
			</form>";
		    die('Must Select A Semester </br> Please Select A Semester To Register' . mysql_error());	
		} 
		
//if valid semester has been chosen, a student will be considered for registration		
echo "<form action='enroll2.php' method='post'>";

  echo '<input type="hidden" name="fname" value="'.$fname.'"/>';
  echo '<input type="hidden" name="lname" value="'.$lname.'"/>';
  echo ' <input type="hidden" name="SID" value="'.$SID.'"/>';
  echo '<input type="hidden" name="semester" value="'.$semester.'"/>';
  echo '<input type="hidden" name="year" value="'.$year.'"/>';

$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use

//SQL query to retrieve the course information for all available courses
$result = mysql_query("SELECT CID, dept, crn, title, credit, day, time, TID, PID FROM courses") or die('Error querying database.');

//implementation of a table with cellspacing of 15. Also the addition of text and buttons to website, 
echo " <table cellspacing='15' >
	   <tr><th></th>
	   <th>CID</th>
	   <th>Department</th>
	   <th>CRN</th>
	   <th>Title</th>
	   <th>Credit</th>
	   <th>Day</th>
	   <th>Time</th>";

//if method with a search variable that hold the value of the string input to the search
if ($search = $_REQUEST['search']){
	//SQL query to retrieve the course information for all available courses matching search input
	$result = mysql_query("SELECT CID, dept, crn, title, credit, day, time, TID, PID, grade FROM courses WHERE courses.title LIKE '%$search%'");
}

static $a = 1;
while($column=mysql_fetch_array($result)){//fetching the information in the database to get all the products and populate the webpage
	echo " </tr><tr><td><input type='radio' name='choice' value=".$a."></td>";
	echo " <td>".$column['CID']."</td>";//printing out the CID of the course
	echo " <td>".$column['1']."</td>";//printing out the Department of the course
	echo " <td>".$column['2']."</td> ";//printing out the CRN of the course
	echo " <td>".$column['3']."</td> ";//printing out the Title of the course
	echo " <td>".$column['4']."</td> ";//printing out the Credit of the course
	echo " <td>".$column['5']."</td> ";//printing out the Day of the course
	echo " <td>".$column['6']."</td> </tr>";//printing out the Time of the course
	$a++;
}

//button to submit registration information
echo "<table cellspacing='15'>
<tr><td><input type='submit' id='Register' value='Register'></td></tr>
</form>";



//button to allow students to search for specific course titles in the courses database
echo " <form method='post'>
<input type='hidden' name='fname' value='$fname'>
<input type='hidden' name='lname' value='$lname'>
<input type='hidden' name='SID' value='$SID'>
<input type='hidden' name='semester' value='$semester'>
<table cellspacing='15'>
<th>Course Search</th>
<th> <input type='text' name='search' ><th>
<input type='submit' value='Search'></table>
</form>";

//provide back button for student to reenter information
echo " <form action='enroll11.php' method='post'>
<table cellspacing='15'>
<input type='hidden' name='fname' value='$fname'>
<input type='hidden' name='lname' value='$lname'>
<input type='hidden' name='SID' value='$SID'>
<tr><td><input type='submit' value='Back'></td></tr></table>
</form>";


mysql_close($dbc);//closing sql database connection

?>
</body>
</html>
