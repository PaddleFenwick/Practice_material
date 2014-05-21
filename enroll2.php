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
h4
{
border-width:15px;
border-style:solid;
border-color:#0096d6;
background-color:white;
font-size:medium;
color:#004065;
margin-left:auto;
margin-right:auto;
width:600px;
}
</style>

<head></head>
<body>
<?php
  $fname = $_POST['fname'];//retrieve the info from the First Name input
  $lname = $_POST['lname'];//retrieve the info from the Last Name input
  $SID = $_POST['SID'];//retrieve the info from the SID input
  $semester = $_POST['semester'];//retrieve the info from the semester input
  $year = '2013';

include ("database.php");

$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to chafeitz database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use

//retrieve data for the course that the student is currently trying to enroll in
$pick = $_REQUEST['choice'];
$query = mysql_query("SELECT * FROM courses WHERE '$pick' = courses.CID");
$column = mysql_fetch_array($query);

//retrieve data for the course(s) that the student is already enrolled in
$check = mysql_query("SELECT * FROM enrolled WHERE '$SID' = enrolled.SID");
$row = mysql_fetch_array($check);
$length = mysql_num_rows($check);

//determine if a student has chosen a course to register for; if not, return error and do not allow student to register
	if (!(isset($pick))) {
		//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='submit' value='Back'>
			</form>";
		    die('Must Select A Course </br> Please Register For A Course' . mysql_error());	
		} 

//if student is already enrolled in classes, check restrictions before allowing registration
if($length!=0){
	while($row = mysql_fetch_array($check)){
		if($semester==$row['semester'] && $column['day']==$row['day'] && $row['TID']==$column['TID'] && $row['grade']!='IP')
		{
			echo "passed<br>";
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
		    die('You have already taken this course! </br> Please Register For A Different Course' . mysql_error());
		}
		//if a student tries to register for a class with the same semester, day, and time
		//they will receive an error and be unable to register for that class
		else if ($semester==$row['semester'] && $column['day']==$row['day'] && $row['TID']==$column['TID']) {
			//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
		    die('Classes Must Be At Least 30 Minutes Apart </br> Please Register For A Different Course' . mysql_error());	
		} 
		//if a students tries to register for a class on a day which they are enrolled in a 
		//4-630 class, they will receive an error due to the 30 minute constraint and be unable to register
		elseif ($semester==$row['semester'] && $column['day']==$row['day'] && $row['TID']=='2') {
			//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
		    die('Classes Must Be At Least 30 Minutes Apart </br> Please Register For A Different Course' . mysql_error());		    
		}
		//if a students tries to register for a 4-630 class on a day which they are enrolled in another class 
		//that day, they will receive an error due to the 30 minute constraint and be unable to register
		elseif ($semester==$row['semester'] && $column['day']==$row['day'] && $column['TID']=='2' && $row['TID']=='3') {
			//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
		    die('Classes Must Be At Least 30 Minutes Apart </br> Please Register For A Different Course' . mysql_error());	    
		}elseif ($semester==$row['semester'] && $column['day']==$row['day'] && $column['TID']=='2' && $row['TID']=='1') {
			//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
		    die('Classes Must Be At Least 30 Minutes Apart </br> Please Register For A Different Course' . mysql_error());	    
		}
	}
}


$temp = mysql_query("SELECT * FROM enrolled WHERE '$SID' = enrolled.SID");

//if a student tries to register for a course without fulfilling prerequisites, return error and do not allow student to register
if($length==0 && $column['P1']<> 0 ){
//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
			 die('All Prerequisites must be completed to register </br> Please Register For A Different Course' . mysql_error());
}
//if the course the student is currently trying to register for has 1 prerequisite
//check if the student has fulfilled the course already; if not, return error and do not allow student to register
	while($row = mysql_fetch_array($temp)){
		 if($column['P1']<> 0 && $row['CRN'] <> $column['P1']){
		 	$length--;
		 	}
		 	if($length==0 && $row['CRN'] <> $column['P1']){
		 	//provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
			 die('All Prerequisites must be completed to register </br> Please Register For A Different Course' . mysql_error());
			} 
		}
$length1 = mysql_num_rows($check); //create second variable of length to calculate the 2nd prerequisite if needed

//if the course the student is currently trying to register for has 2 prerequisites and has fulfilled the first
//check if the student has fulfilled the 2nd course already; if not, return error and do not allow student to register
if($column['P2']<> 0 ){		
	while($row = mysql_fetch_array($temp)){
		 if($column['P2']<> 0 && $row['CRN'] <> $column['P2']){
		 	$length1--;
		 	}
		 if($column['P2']<> 0 && $length1==0 && $row['CRN'] <> $column['P2']){
		 //provide back button for student to reenter information
			echo " <form action='enroll1.php' method='post'>
			<input type='hidden' name='fname' value='$fname'>
			<input type='hidden' name='lname' value='$lname'>
			<input type='hidden' name='SID' value='$SID'>
			<input type='hidden' name='semester' value='$semester'>
			<input type='submit' value='Back'>
			</form>";
			 die('All Prerequisites must be completed to register </br> Please Register For A Different Course' . mysql_error());
			} 
		}
	}
	

$query = "INSERT INTO enrolled (fname, lname, SID, CID, CRN, title, credits, semester, year, day, TID, PID, grade) VALUES ('$fname', '$lname', '$SID',  '".$column['crn']."','$pick','".$column['title']."','".$column['credit']."', '$semester', '$year','".$column['day']."', '".$column['TID']."','".$column['PID']."', 'IP')";
$result = mysql_query($query)
    or die('Error querying database.  '.$query);
    

    //if a student has successfully been registered for a new course, display the information of the newly registered course
	echo 'You are now enrolled in: <br/>';
	echo " <td>".$column['0']."</td>";
	echo " </tr><tr>";
	echo " <td>".$column['1']."</td>";
	echo " </tr><tr>";
	echo " <td>".$column['2']."</td> ";
	echo " </tr><tr>";
	echo " <td>".$column['3']."</td> ";
	echo " </tr><tr>";
	echo " <td>".$column['4']."</td> ";
	echo " </tr><tr>";
	echo " <td>".$column['5']."</td> ";
	echo " </tr><tr>";
	echo " <td>".$column['6']."</td><br/>";
	
	
//provide a back button for the student to use to navigate back to the course registration page
echo " <form action='enroll1.php' method='post'>
<input type='hidden' name='fname' value='$fname'>
<input type='hidden' name='lname' value='$lname'>
<input type='hidden' name='SID' value='$SID'>
<input type='hidden' name='semester' value='$semester'>
<input type='submit' value='Back'>
</form>";
echo "<br><br><a href='application/start.html'>Log Out</a><br><br>";

 mysql_close($dbc);//closing sql database connection


?>

</body>
</html>
