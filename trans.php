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

<head>
  <title>Student Transcript</title>
</head>
<body>
  <h2><br>Student Transcript<br><br></h2>
<?php
//special php file for functions to add and delete items from cart

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $SID = $_POST['SID'];
  if(empty($fname))
  {
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $SID = $_GET['SID'];
  }
include ("database.php");
 $dbc = mysql_connect("localhost", $dbUser, $dbPass)
    or die('Error connecting to MySQL server.');
  
   mysql_select_db($dbName, $dbc);

  //select the transcript information of a current student with correct first name, last name, and student ID
  $query = mysql_query("SELECT * FROM enrolled WHERE '$SID' = enrolled.SID AND '$fname' = enrolled.fname AND '$lname' = enrolled.lname") or die('Error querying database.');
  //select the total number of credits (sum of 'credits' column) earned by the same student with correct first name, last name, and student ID
  $credit =  mysql_query("SELECT SUM(credits) AS value_sum FROM enrolled WHERE '$SID' = enrolled.SID AND '$fname' = enrolled.fname AND '$lname' = enrolled.lname") or die('Error querying database.');
  //obtain the value of the sum of the credits column and convert it into a variable
  $c = mysql_fetch_assoc($credit); 
  $sum = $c['value_sum'];
  
  $gpa =  mysql_query("SELECT avg(gpa) AS gpa_sum FROM enrolled WHERE '$SID' = enrolled.SID AND '$fname' = enrolled.fname AND '$lname' = enrolled.lname") or die('Error querying database.');
  $g = mysql_fetch_assoc($gpa); 
  $avg = $g['gpa_sum'];
    
    //$column = mysql_fetch_array($query);
    echo "<h3>Student Name: ";
	echo " <td>".$fname."</td>";
	echo " <td>".$lname."</td></br>";
	echo "Student ID: ";
	echo " <td>".$SID."</td></br>";
	echo "Total Credits Earned: ";
	echo " <td>".$sum."</td></br>";
	echo "Total GPA: ";
	echo " <td>".$avg."</td></br></h3>";

    
    echo"<table class='one' cellspacing='15' align='center'><tr>
	<th>Course ID</th>
	<th>Title</th>
	<th>Credits</th>
	<th>Semester</th>
	<th>Year</th>
	<th>Grade</th>";

while($column=mysql_fetch_array($query)){//fetching the information in the database to get all the products and populate the webpage
	echo " </tr><tr>";
	echo " <td>".$column['CID']."</td>";//printing out the first column of the table that holds the product's name
	echo " <td>".$column['title']."</td>";//printing out the third column of the table that holds the price of each product
	echo " <td>".$column['credits']."</td> ";//printing out the fifth column of the table that holds the category of each product
	echo " <td>".$column['semester']."</td> ";
	echo " <td>".$column['year']."</td> ";
	echo " <td>".$column['grade']."</td> ";

}
//implement button to return user to previous page
#echo " <form action='enroll11.php' method='post'>
#<table cellspacing='15' align='center'>
#<input type='hidden' name='fname' value='$fname'>
#<input type='hidden' name='lname' value='$lname'>
#<input type='hidden' name='SID' value='$SID'>
#<tr><td><input type='submit' value='Back'></td></tr></table>
#</form>";
echo "<br><br><a href='application/start.html'>Log Out</a><br><br>";

  mysql_close($dbc); //closing sql database connection


?>


</body>
</html>
