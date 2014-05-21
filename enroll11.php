<!DOCTYPE html>
<html>

<style>
body
{

background-color:#ffeebb;
color:#004065;
font-family:Tahoma;
text-align:center;


}
table.one {
	border-width: 15px;
	border-style: solid;
	border-color:#0096d6;
	background-color: white;
	color:#004065;
}
h2
{
border-width:15px;
border-style:solid;
border-color:#0096d6;
background-color:#004065;
font-size:x-large;
color:#ffeebb;
}
h3
{
border-width:5px;
border-style:solid;
border-color:#0096d6;
background-color:white;
font-size:medium;
color:#004065;
margin-left:auto;
margin-right:auto;
width:400px;
}
</style>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Student Course Registration</title>
</head>
<body>
  <h2><br>Student Options Page<br><br></h2>

<?php
include ("database.php");
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $SID = $_POST['SID'];
    if(empty($fname))
    {
    $fname = $_GET['fname']; //retrieve the info from the First Name textbox
    $lname = $_GET['lname']; //retrieve the info from the Last Name textbox
  	$SID = $_GET['SID']; //retrieve the info from the Password textbox
    }
  	echo '<input type="hidden" name="fname" value="'.$fname.'"/>';
  	echo '<input type="hidden" name="lname" value="'.$lname.'"/>';
  	echo ' <input type="hidden" name="SID" value="'.$SID.'"/>';
  	$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
	or die('Error connecting to MySQL server.');//show error if connection cannot be established

	mysql_select_db($dbName, $dbc);//selecting efusco database to use
	
	//SQL query to retrieve the student information matches with the name and SID input to the log in screen
	$query = "SELECT * FROM Personal_info WHERE '$SID' = studentid AND '$fname' = name AND '$lname' = last_name";
	$res = mysql_query($query) or die('Error querying database.');
	//if the SQL query does not return student information matching the log in into, user is not a student and will receive error
	if (mysql_num_rows($res)==0) {
		echo " <form action='login1.html' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='submit' value='Back'>
			</form>";
    die('User must be a student to register for classes' . mysql_error());
} 

mysql_close($dbc);//closing sql database connection

   ?> 
   
<!-- html code to register for classes -->
  <form action="enroll1.php" method="post">
  	<!-- form for student to select semester of study
  	year of enrollment is atuomatically 2013
  	student may select 1 of 3 semester input choices-->
	<h3><br>Register for 2013 Classes<br><br>
	<h4> Select Semester: </h4>
			Spring
	<input	type="radio" name="semester" value="Spring"	/>
			Fall
	<input	type="radio" name="semester" value="Fall"	/>
			Summer
	<input	type="radio" name="semester" value="Summer"	/><br	/><br/>
    <input type="submit" value="Register for Courses" name="submit" /> 
    
     <?php
    //if student is valid, send student information to allow enrollment
    
    $fname = $_POST['fname']; //retrieve the info from the First Name textbox
  	$lname = $_POST['lname']; //retrieve the info from the Last Name textbox
    $SID = $_POST['SID']; //retrieve the info from the Password textbox
    if(empty($SID))
    {
        $fname = $_GET['fname']; //retrieve the info from the First Name textbox
  	    $lname = $_GET['lname']; //retrieve the info from the Last Name textbox
        $SID = $_GET['SID']; //retrieve the info from the Password textbox
    }
  	echo '<input type="hidden" name="fname" value="'.$fname.'"/>';
  	echo '<input type="hidden" name="lname" value="'.$lname.'"/>';
  	echo ' <input type="hidden" name="SID" value="'.$SID.'"/>';
  	
   ?>

  </form></h3>
  	<h3><br>View Current Transcript<br><br></h3>
<form action="trans.php" method="post">
	<input type="submit" value="View Your Transcript" name="submit" />
   <?php
   	//if student is valid, send student information to retrieve transcript
    $fname = $_POST['fname']; //retrieve the info from the First Name textbox
  	$lname = $_POST['lname']; //retrieve the info from the Last Name textbox
    $SID = $_POST['SID']; //retrieve the info from the Password textbox
    if(empty($SID))
    {
        $fname = $_GET['fname']; //retrieve the info from the First Name textbox
  	    $lname = $_GET['lname']; //retrieve the info from the Last Name textbox
        $SID = $_GET['SID']; //retrieve the info from the Password textbox
    }
  	echo '<input type="hidden" name="fname" value="'.$fname.'"/>';
  	echo '<input type="hidden" name="lname" value="'.$lname.'"/>';
  	echo ' <input type="hidden" name="SID" value="'.$SID.'"/>';
  	
  	echo "<br><br><a href='application/start.html'>Log Out</a><br><br>";

   ?>
  </form>
  
</body>
</html>
