<html>
<h1>STUDENTS & ALUMNI LIST</h1>


<?php

include('database.php');
$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use



$rdegree = mysql_query("SELECT DISTINCT AcademicInfo.degree FROM AcademicInfo");//SQL query to retreive the available degree programs in students table
$ryear = mysql_query("SELECT DISTINCT AcademicInfo.admitYear FROM AcademicInfo ORDER BY admitYear ASC");//SQL query to retreive the available years in students table
$rsemester = mysql_query("SELECT DISTINCT AcademicInfo.admitSem FROM AcademicInfo");//SQL query to retreive the available semesters in students table
$rstatus = mysql_query("SELECT DISTINCT Personal_info.status FROM Personal_info");//SQL query to retreive the available years in students table



echo "<table cellspacing = '15'>
<form action='list.php' method='post'>";
echo "<th>Degree Program</th>";
echo "<td><select name='degree'>";//introducing a dropdown menu
echo "<option value='---'></option>";
while($column=mysql_fetch_array($rdegree)){//fetching the information in the database to get all the information from the query that retrieves the available degre programs 
	echo " 
	<option value='".$column['0']."'>".$column['0']." </option>";//format for the dropdown menu to print out the degree programs
}
echo "<td></select>";//closing dropdown menu


echo "<th>Year</th>";
echo "<td><select name='year'>";//introducing a dropdown menu
echo "<option value='---'></option>";
while($column=mysql_fetch_array($ryear)){//fetching the information in the database to get all the information from the query that retrieves the available years
	echo " 
	<option value='".$column['0']."'> ".$column['0']." </option>";//format for the dropdown menu to print out the years
}
echo "<td></select>";//closing dropdown menu


echo "<th>Semester</th>";
echo "<td><select name='semester'>";//introducing a dropdown menu
echo "<option value='---'></option>";
while($column=mysql_fetch_array($rsemester)){//fetching the information in the database to get all the information from the query that retrieves the available semesters
	echo " 
	<option value='".$column['0']."'>".$column['0']." </option>";//format for the dropdown menu to print out the semesters
}
echo "<td></select>";//closing dropdown menu


echo "<th>Status</th>";
echo "<td><select name='status'>";//introducing a dropdown menu
echo "<option value='---'></option>";
while($column=mysql_fetch_array($rstatus)){//fetching the information in the database to get all the information from the query that retrieves the available statuses
	echo " 
	<option value='".$column['0']."'>".$column['0']." </option>";//format for the dropdown menu to print out the statuses
}
echo "<td></select>";//closing dropdown menu


$degree = $_REQUEST['degree'];//requesting the value of the option selected in the degree dropdown menu
$year = $_REQUEST['year'];//requesting the value of the option selected in the year dropdown menu
$semester = $_REQUEST['semester'];//requesting the value of the option selected in the semester dropdown menu
$status = $_REQUEST['status'];//requesting the value of the option selected in the status dropdown menu


//adding a submit button passing the values from the dropdown menus
echo "
<td><input type='submit' value='Submit'></td>
</table>
</form>
";

//adding titles for each column
echo"
<table cellspacing='15'>
<tr>
<th>SID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Semester</th>
<th>Year</th>
<th>Degree Program</th>
<th>Status</th>
<th>Email</th>
</tr>
";

$a = "SELECT DISTINCT Personal_info.studentid, Personal_info.name, Personal_info.last_name, AcademicInfo.admitYear, AcademicInfo.admitSem, AcademicInfo.degree, Personal_info.status, Personal_info.email FROM Personal_info, AcademicInfo WHERE AcademicInfo.degree = '$degree' OR AcademicInfo.admitYear = '$year' OR AcademicInfo.admitSem = '$semester' OR Personal_info.status = '$status' AND Personal_info.studentid = AcademicInfo.SID";
$result = mysql_query($a) or die('Error querying database.');//SQL query to retreive all the students' ID, name, year, degree, semester from the students database


while($column=mysql_fetch_array($result)){//fetching the information in the database to get all the students info form the class, from the SQL query above
	echo " </tr><tr><td>".$column['0']."</td>";//printing out the first column of the table that holds the Students' ID
	echo " <td>".$column['1']."</td>";//printing out the second column of the table that holds the students' first name
	echo " <td>".$column['2']."</td> ";//printing out the third column of the table that holds the students' last name
	echo " <td>".$column['4']."</td> ";//printing out the third column of the table that holds the students' year
	echo " <td>".$column['3']."</td> ";//printing out the third column of the table that holds the students' semester
	echo " <td>".$column['5']."</td> ";//printing out the third column of the table that holds the students' degree program
	echo " <td>".$column['6']."</td> ";//printing out the third column of the table that holds the students' status
	echo " <td>".$column['7']."</td> ";//printing out the third column of the table that holds the students' status
}


mysql_close($dbc);//closing sql database connection

?>
</html>
