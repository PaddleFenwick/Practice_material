<html>
<h1>COURSE SELECTION</h1>


<?php
include ("database.php");


$fname = $_POST['fname'];//getting the info from the First Name textbox
$lname = $_POST['lname'];//getting the info from the Last Name textbox
$PID = $_POST['password'];//getting the info from the Password textbox
if(empty($fname))
{
$fname = $_GET['fname'];//getting the info from the First Name textbox
$lname = $_GET['lname'];//getting the info from the Last Name textbox
$PID = $_GET['PID'];//getting the info from the Password textbox
    
}

$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to efusco database
or die('Error connecting to MySQL server.');//show error if connection cannot be established
mysql_select_db($dbName, $dbc);//selecting efusco database to use


$query = "SELECT * FROM professors WHERE '$PID' IN (SELECT PID FROM professors) AND '$fname' IN (SELECT fname FROM professors) AND '$lname' = (SELECT lname FROM professors WHERE professors.PID = '$PID')";//SQL query to check if the information submitted is valid and allow entrance to website
$res = mysql_query($query) or die('Error querying database. Query is '.$query);//an error message will appear if the info is not valid
if (mysql_num_rows($res)==0) {
	die('Must Be A Professor Or Graduate Secretary To Assign Grades'. mysql_error());
} 


$n = mysql_query("SELECT lname FROM professors WHERE professors.PID = $PID") or die('Error querying database.');//SQL query to print out the professor's name according to the Professor ID submitted
$name = mysql_fetch_array($n);//variable "name" to represent the info from the previous query
echo "<th>Professor </th>";//print out "professors"
echo $name[0];//print out the value of the variable "name" that has the professor's name

if($PID=='1111555'){//if statement, to check if the introduced ID is the one from the Grad Secretary
	$result = mysql_query("SELECT DISTINCT courses.crn, courses.title FROM enrolled, courses WHERE enrolled.CID = courses.crn");//if the grad secretary logged in then the SQL query will print out all the existing courses
}else{
	$result = mysql_query("SELECT DISTINCT courses.crn, courses.title FROM enrolled, courses WHERE enrolled.PID = $PID AND enrolled.CID = courses.crn") or die('Error querying database.');//SQL query to retreive the courses corresponding to the professor that logged in
}

echo"
<form action='course.php' method='post'>
<table cellspacing='15'>
<input type='hidden' name='password' value='".$PID."'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<tr>
<th>Course</th>
<th> <input type='text' name='search' ><th>
<input type='submit' value='Search'>
</tr>
</form>
";

if ($search = $_REQUEST['search']){//if method with a search variable that hold the value of the string input to the search
	$results = mysql_query("SELECT DISTINCT courses.crn, courses.title FROM enrolled, courses WHERE enrolled.PID = $PID AND enrolled.CID = courses.crn OR courses.title = '$search' OR courses.crn = '$search'");//SQL query to retrieve the student name and ID that matches with the name input to the search box
}



echo"	
<form action='grades.php' method='post'>
<table cellspacing='15'>
<tr>
<input type='hidden' name='password' value='".$PID."'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<th>Course</th>
";


echo "<td><select name='course'>";//introducing a dropdown menu
while($column=mysql_fetch_array($result)){//fetching the information in the database to get all the information from the query that retrieves the professor's courses. 
	echo " 
	<option value='".$column['0']."'>".$column['1']."- ".$column['0']." </option>";//format for the dropdown menu to print out the title and CRN
}
echo "<td></select>";//closing dropdown menu

echo "
<td><input type='submit' value='Submit'></td>
</tr>
</form>";//adding a submit button to access the grades



echo"
<table cellspacing='15'>
<tr>
<th>Course Number</th>
<th>Title</th>
</tr>
";

echo "
<form action='grades.php' method='post'>";

while($column=mysql_fetch_array($results)){//fetching the information in the database to get all the courses info from the database, from the SQL query above
	echo "<tr><td>".$column['0']."</td>";//printing out the first column of the table that holds the course title
	echo "<td>".$column['1']."</td>";//printing out the second column of the table that holds the course number
	echo "<td><input type='radio' name='course' value=".$column['0']."></td></tr>";//adding a radio button for each search result
}


echo "
<input type='hidden' name='password' value='".$PID."'>
<input type='hidden' name='fname' value='".$fname."'>
<input type='hidden' name='lname' value='".$lname."'>
<td><input type='submit' value='Submit'></td>
</form>
";



if($PID=='555'){//if the PID 555 logged in (the GS) then add a 'View Transcripts' button
	echo "
	<form action='transcripts.php' method='post'>
	<table cellspacing='15'>
	<tr>
	<input type='hidden' name='fname' value='".$fname."'>
	<input type='hidden' name='lname' value='".$lname."'>
	<input type='hidden' name='password' value='".$PID."'>
	<input type='submit' value='View Transcripts'>
	</tr>
	</form>";
}


mysql_close($dbc);//closing sql database connection

?>
</html>
