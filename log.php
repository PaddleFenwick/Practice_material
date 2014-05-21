<html>
<body style="background-color:lightgray;">
<h2 style="text-align:center;color:red">LOG IN</h2>
<form method="post" action = "login.html">
<center>
<th>FACULTY</th>
<input type="submit" value="GO TO LOG IN"/>
</center>
</form>
<form method="post" action = "login1.html">
<center>
<th>STUDENT</th>
<input type="submit" value="GO TO LOG IN"/>
</center>
</form>

<form method="post" action = "log.php">
<center>
<input type="submit" name="reset" value="RESET DATABASES"/>
</center>
<?php
include ("database.php");
//if databases have been reset, notify user
if(isset($_POST['reset'])) {
	echo "</br><center>";
	echo "Databases have been reset.";
	echo "</center>";

}

$dbc = mysql_connect("localhost", $dbUser, $dbPass)//connection to chafeitz database
or die('Error connecting to MySQL server.');//show error if connection cannot be established

mysql_select_db($dbName, $dbc);//selecting efusco database to use


//clearing all data from the tables
$enrolled = mysql_query("DELETE FROM enrolled");

$students = mysql_query("DELETE FROM students");

$courses = mysql_query("DELETE FROM courses");

$professors = mysql_query("DELETE FROM professors");

//inputting data to the tables
mysql_query("INSERT INTO courses VALUES (1, 'CS', 6221, 'Software Paradigms', 3, 'M', '3-5:30pm', 1, 1111501, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (2, 'CS', 6461, 'Computer Architecture', 3, 'T', '3-5:30pm', 1, 1111501, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (3, 'CS', 6212, 'Algorithms', 3, 'W', '3-5:30pm', 1, 1111501, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (4, 'CS', 6225, 'Data Compression', 3, 'R', '3-5:30pm', 1, 1111501, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (5, 'CS', 6232, 'Networks 1', 3, 'M', '6-8:30pm', 3, 1111501, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (6, 'CS', 6233, 'Networks 2', 3, 'T', '6-8:30pm', 3, 1111502, '', 5, 0)");
mysql_query("INSERT INTO courses VALUES (7, 'CS', 6241, 'Database 1', 3, 'W', '6-8:30pm', 3, 1111502, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (8, 'CS', 6242, 'Database 2', 3, 'R', '6-8:30pm', 3, 1111502, '', 7, 0)");
mysql_query("INSERT INTO courses VALUES (9, 'CS', 6246, 'Compilers', 3, 'T', '3-5:30pm', 1, 1111502, '', 2, 3)");
mysql_query("INSERT INTO courses VALUES (10, 'CS', 6251, 'Distributed Systems', 3, 'M', '6-8:30pm', 3, 1111502, '', 2, 0)");
mysql_query("INSERT INTO courses VALUES (11, 'CS', 6254, 'Software Engineering', 3, 'M', '3-5:30pm', 1, 1111503, '', 1, 0)");
mysql_query("INSERT INTO courses VALUES (12, 'CS', 6260, 'Multimedia', 3, 'R', '6-8:30pm', 3, 1111503, '', 1, 0)");
mysql_query("INSERT INTO courses VALUES (13, 'CS', 6262, 'Graphics 1', 3, 'W', '6-8:30pm', 3, 1111503, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (14, 'CS', 6283, 'Security 1', 3, 'T', '6-8:30pm', 3, 1111503, '', 3, 0)");
mysql_query("INSERT INTO courses VALUES (15, 'CS', 6284, 'Cryptography', 3, 'M', '6-8:30pm', 3, 1111503, '', 3, 0)");
mysql_query("INSERT INTO courses VALUES (16, 'CS', 6286, 'Network Security', 3, 'W', '6-8:30pm', 3, 1111504, '', 14, 5)");
mysql_query("INSERT INTO courses VALUES (17, 'CS', 6325, 'Advanced Algorithms', 2, 'R', '4-6:30pm', 2, 1111504, '', 3, 0)");
mysql_query("INSERT INTO courses VALUES (18, 'CS', 6339, 'Embedded Systems', 2, 'T', '3-5:30pm', 1, 1111504, '', 2, 3)");
mysql_query("INSERT INTO courses VALUES (19, 'CS', 6841, 'Advanced Crypto', 3, 'M', '6-8:30pm', 3, 1111504, '', 15, 14)");
mysql_query("INSERT INTO courses VALUES (20, 'EE', 6243, 'Communication Systems', 3, 'M', '6-8:30pm', 3, 1111505, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (21, 'EE', 6244, 'Information Theory', 2, 'T', '6-8:30pm', 3, 1111505, '', 0, 0)");
mysql_query("INSERT INTO courses VALUES (22, 'Math', 6210, 'Logic', 2, 'W', '6-8:30pm', 3, 1111505, '', 0, 0)");

mysql_query("INSERT INTO students VALUES (1, 'Karen', 'Smith', '22802 August Leaf Dr Tomball, TX', 'M.S.', 'Graduated', 'Fall', 2003, '')");
mysql_query("INSERT INTO students VALUES (2, 'Peter', 'Adams', '13902 E Marina Dr Boulder, CO', 'M.S.', 'Graduated', 'Summer', 2003, '')");
mysql_query("INSERT INTO students VALUES (3, 'Anna', 'Kip', '11 Lakeside Rd Bedford Corners, NY', 'M.S.', 'Cleared', 'Spring', 2009, '')");
mysql_query("INSERT INTO students VALUES (4, 'Carly', 'Webb', '9 Spring Lake Pt Pearl, MS', 'M.S.', 'Applied', 'Fall', 2011, '')");
mysql_query("INSERT INTO students VALUES (5, 'Jean', 'Riley', '219 3rd Ave Belmar, NJ', 'M.S.', 'Graduated', 'Summer', 2010, '')");


mysql_query("INSERT INTO professors VALUES ('1111501', 'Roger', 'Stone', '0', 'CSCI', 'rstone@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111502', 'Lucas', 'Jackson', '0', 'CSCI', 'ljackson@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111503', 'Amanda', 'Vora', '0', 'CSCI', 'avora@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111504', 'Mewelde', 'Moore', '0', 'CSCI', 'moore@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111505', 'Martha', 'Duques', '0', 'CSCI', 'mduques@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111555', 'Emily', 'Wall', '0', 'CSCI', 'ewall@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111666', 'Bhagi', 'Narahari', '0', 'CSCI', 'narahari@gwu.edu')");
mysql_query("INSERT INTO professors VALUES ('1111600', 'Timothy', 'Wood', '0', 'CSCI', 'timwood@gwu.edu')");



mysql_close($dbc);//closing sql database connection


?>
</form>
</html>

