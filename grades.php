<html>
<h1>GRADE ASSIGNING</h1>


<?php

$PID = $_POST['password'];//getting the info from the Professor ID textbox
$CID = $_POST['course'];//getting the info from the course id represented in a hidden variable in course.php
$fname = $_POST['fname'];//getting the info from the variable fname
$lname = $_POST['lname'];//getting the info from the variable lname
include ("database.php");
$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use

$result = mysql_query("SELECT DISTINCT Personal_info.studentid, Personal_info.name, Personal_info.last_name FROM Personal_info, enrolled WHERE enrolled.SID = Personal_info.studentid AND enrolled.CID = $CID ORDER BY SID ASC") or die('Error querying database.');//SQL query to retreive all the students' name and ID from the respective class


echo "<th>COURSE</th><td> </td>";//print out the word "Course"
echo $CID;//print out the value of the variable that represents the info submitted in the text box in the login page

//implementation of a table with cellspacing of 15. Also the addition of text and buttons to website, 
echo"
<form method='post'>
<input type='hidden' name='pid' value='$PID'>
<input type='hidden' name='course' value='$CID'>
<table cellspacing='15'>
<th>Student</th>
<th> <input type='text' name='search' ><th>
<input type='submit' value='Search'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<input type='hidden' name='password' value='".$PID."'>
</form>

<form action='assign.php' method='post'>
<input type='hidden' name='cid' value='".$CID."'>
<tr><th>SID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Grade</th>
";

if ($search = $_REQUEST['search']){//if method with a search variable that hold the value of the string input to the search
	$result = mysql_query("SELECT DISTINCT Personal_info.studentid, Personal_info.name, Personal_info.last_name FROM Personal_info, enrolled WHERE enrolled.SID = Personal_info.studentid OR Personal_info.name = '$search' OR Personal_info.last_name = '$search'");//SQL query to retrieve the student name and ID that matches with the name input to the search box
}

$x = 1;
while($column=mysql_fetch_array($result)){//fetching the information in the database to get all the students info form the class, from the SQL query above
	echo " </tr><tr><td>".$column['0']."</td>";//printing out the first column of the table that holds the Students' ID
	echo " <td>".$column['1']."</td>";//printing out the second column of the table that holds the students' first name
	echo " <td>".$column['2']."</td> ";//printing out the third column of the table that holds the students' last name
	//drop down menu for the grades, which displays every possible grade that could be assigned. 
	echo "<td><select name='grade".$column['0']."'>
	<option value='---'></option>
	<option value='A'>A</option>
	<option value='A-'>A-</option>
	<option value='B+'>B+</option>
	<option value='B'>B</option>
	<option value='B-'>B-</option>
	<option value='C+'>C+</option>
	<option value='C'>C</option>
	<option value='F'>F</option>
    </select></td>";

    echo "<input type='hidden' name='num".$x."' value='".$column['0']."'>";	

	$x++;
}

echo "<input type='hidden' name='length' value='".$x."'>";//hidden variable that holds how many students are in the class

//adding a submit button to submit the grades selection
echo "
<table cellspacing='15'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<input type='hidden' name='password' value='".$PID."'>
<td><td><input type='submit' value='Submit'></td></td>
</form>";

//back button to go to courses from grades
echo " <form action='course.php' method='post'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<input type='hidden' name='password' value='".$PID."'>
<td><td><input type='submit' value='Back'></td></td>
</form>";


mysql_close($dbc);//closing sql database connection

?>
</html>
