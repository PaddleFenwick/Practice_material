<html>
<h1>Student Transcript</h1>


<?php
include ("database.php");
$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use


$fname = $_POST['fname'];//getting the info from the First Name textbox
$lname = $_POST['lname'];//getting the info from the Last Name textbox
$PID = $_POST['password'];//getting the info from the Password textbox


echo"
<form action='transcripts.php' method='post'>
<table cellspacing='15'>
<tr>
<th>Student</th>
<th> <input type='text' name='search' ><th>
<input type='submit' value='Search'>
</tr>
</form>
";

$search = $_REQUEST['search'];

//implementation of a table with cellspacing of 15. Also the addition of text and buttons to website, 
echo"	
<form>
<form action='transcripts.php' method='post'>
<table cellspacing='15'>
<th>Student</th>";

$result = mysql_query("SELECT DISTINCT fname, lname FROM enrolled") or die('Error querying database.');//SQL query to retreive the name of the student from the transcripts table

//introducing a dropdown menu
echo "<td><select name='student'>
<option value='---'></option>";

while($column=mysql_fetch_array($result)){//fetching the information in the database to get all the information from the query that retrieves the students' name
	echo " 
	<option value='".$column['1']."'>".$column['1'].", ".$column['0']." </option>";//format for the dropdown menu to print out the title and CRN
}
echo "</select></td>";//closing dropdown menu

//adding a submit button to access the grades
echo "
<td><td><input type='submit' value='Submit'></td></td>
<input type='hidden' name='password' value='".$PID."'>";


$student = $_REQUEST['student'];//variable with value of the dropdown menu selected option


//sql query to retrieve the student that matches the option selected in the dropdown menu
$ss = mysql_query("SELECT enrolled.fname, enrolled.lname FROM enrolled WHERE enrolled.lname = '$student'");
$sss = mysql_fetch_array($ss);


$nn = mysql_query("SELECT enrolled.fname, enrolled.lname FROM enrolled WHERE enrolled.fname = '$search' OR enrolled.lname = '$search'");
$nnn = mysql_fetch_array($nn);

echo "Student: ";//print out "student"
echo $sss['fname']."   ".$sss['lname'];

echo $nnn['fname']."   ".$nnn['lname'];

//sql query to retrive the transcripts from the student that was searched
$trans = mysql_query("SELECT DISTINCT CID, title, credits, semester, year, grade FROM enrolled WHERE enrolled.lname = '$student' OR enrolled.fname = '$search' OR enrolled.lname = '$search'") or die("Dying");//SQL query to retreive the transcript information corresponding the student selected in the dropdown menu


//printing out titles for the page
echo"
<input type='hidden' name='cid' value='".$CID."'>
<tr>
<th>Course ID</th>
<th>Title</th>
<th>Credits</th>
<th>Semester</th>
<th>Year</th>
<th>Grade</th>
</tr>
</form>";

//sql query for the search function where it gets the value from the search text box
$u = mysql_query("SELECT SID FROM enrolled WHERE '$student' = enrolled.lname OR '$search' = enrolled.fname OR '$search' = enrolled.lname");
$SID = mysql_fetch_array($u);


//select the total number of credits (sum of 'credits' column) earned by the same student with correct first name, last name, and student ID
$credit =  mysql_query("SELECT SUM(credits) AS value_sum FROM enrolled WHERE '$student' = enrolled.lname OR '$search' = enrolled.fname OR '$search' = enrolled.lname") or die('Error querying database.');

//obtain the value of the sum of the credits column and convert it into a variable
$c = mysql_fetch_assoc($credit); 
$sum = $c['value_sum'];

//obtain the value of the average of the GPA's and convert it into a variable
$gpa =  mysql_query("SELECT avg(gpa) AS gpa_sum FROM enrolled WHERE '$student' = enrolled.lname OR '$search' = enrolled.fname OR '$search' = enrolled.lname") or die('Error querying database.');
$g = mysql_fetch_assoc($gpa); 
$avg = $g['gpa_sum'];


while($column=mysql_fetch_array($trans)){//fetching the information in the database to get all the students info form the class, from the SQL query above
	echo " </tr><tr><td>".$column['0']."</td>";//printing out the first column of the table that holds the course ID
	echo " <td>".$column['1']."</td>";//printing out the second column of the table that holds the class title
	echo " <td>".$column['2']."</td> ";//printing out the third column of the table that holds the credits
	echo " <td>".$column['3']."</td> ";//printing out the fourth column of the table that holds the semester
	echo " <td>".$column['4']."</td> ";//printing out the fifth column of the table that holds the year
	echo " <td>".$column['5']."</td> ";//printing out the sixth column of the table that holds the grades	
}

//printing out the total credits and total GPA
echo " 
<br>Total Credits Earned: $sum</br>
<tr>Total GPA: $avg</tr>";



mysql_close($dbc);//closing sql database connection

?>
</html>
