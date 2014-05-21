
<?php
  $fname = $_POST['fname'];//retrieve the info from the First Name input
  $lname = $_POST['lname'];//retrieve the info from the Last Name input
  $SID = $_POST['SID'];//retrieve the info from the SID input
  $semester = $_POST['semester'];//retrieve the info from the semester input
  $year = '2013';

include('database.php');
$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to chafeitz database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use

//retrieve data for the course that the student is currently trying to enroll in
$pick = $_REQUEST['dchoice'];
echo $pick;
mysql_query("DELETE FROM enrolled WHERE'$SID'=enrolled.SID AND '$pick'=enrolled.CRN") or die('Error querying database.');
    
//
    //if a student has successfully been registered for a new course, display the information of the newly registered course
	echo 'You are no longer enrolled in selected course. <br/>';
	
	
	
//provide a back button for the student to use to navigate back to the course registration page
echo " <form action='enroll1.php' method='post'>
<input type='hidden' name='fname' value='$fname'>
<input type='hidden' name='lname' value='$lname'>
<input type='hidden' name='SID' value='$SID'>
<input type='hidden' name='semester' value='$semester'>
<input type='submit' value='Back'>
</form>";

 mysql_close($dbc);//closing sql database connection


?>
