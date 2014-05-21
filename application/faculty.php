<html>

<style>
body
{

background-color:#ffeebb;
color:#004065;
font-family:Tahoma;
text-align:center;

}

p.one
{
border-width:15px;
border-style:solid;
border-color:#0096d6;
background-color:#c8b18b;
font-size:large;
color:white;
}
h2
{
border-width:15px;
border-style:solid;
border-color:#0096d6;
background-color:#004065;
font-size:x-large;
color:#ffeebb;
text-align:center;

}
table.one {
	text-align:center;
	border-width: 15px;
	border-style: solid;
	border-color:#0096d6;
	width: 760px;
	background-color: white;
	color:#004065;
}

a:link {color:#0096d6;}    /* unvisited link */
a:visited {color:#c8b18b;} /* visited link */


</style>

<head>
    <title>Faculty Homepage review apps, add recs to student, change password</title>
    </head>
    <body>
<table class="one" align='center'>

<?php 
//server database info
#$dbUser = "lucasch";
#$dbPass = "iamadmin";
#$dbName = "termProject";

// includes the database info
#include ($_SERVER['DOCUMENT_ROOT']."/database.php");
#include("database.php");
include ("../database.php");

//grab the faculty id
$fid = $_GET['fid'];




//connect to the database
$dbc = mysql_connect("localhost", $dbUser, $dbPass)
    or die('Error connecting to Mysql server');

//select the database
mysql_select_db($dbName,$dbc);


function getFacName(){
 global $fid;
//query to retrieve students SIDs and names
$query = "Select * from professors where PID = $fid";

//run the query grab the result set
$result = mysql_query($query)
    or die('getFacNames:Error querying database. '.$query);

return mysql_fetch_array($result);
}

$info = getFacName();


echo "<h2><br>Welcome ".$info['fname']." ".$info['lname']."<br><br></h2>";
echo "<tr><td>";


//query to retrieve students SIDs and names
$query = "Select name, last_name, studentid from Personal_info where status='applicant' ";

//run the query grab the result set
$result = mysql_query($query)
    or die('Names:Error querying database.');



//grab the result array


echo "<h5>&emsp;&emsp;Review Students:&emsp;&emsp;&emsp;</h5>";
echo "<form method ='post' action='../review/review.php?fid=".$fid."'>";
echo '<select size ="10" name="sid">';
echo "<option selected>None";
while($student = mysql_fetch_assoc($result))
{
    $sid = $student['studentid'];
    $name = $student['name']." ".$student['last_name'];
    echo "<option value=$sid>$name";

}
echo '</select><br>';
echo '<input type="submit" value="Review Student" name="submit" />';

echo "</form>";

echo "</td><td>";
addAdvisees();
echo "</td><td>";


addRecommends();

function addAdvisees(){

//creates the form to add students who need to be recommended
 global $fid;
$info = getFacName();

//query to retrieve students SIDs and names
//$query = "Select * from Recommendation where recFirstName = '".$info['faccFirstName']."' and recLastName='".$info['faccLastName']."' and recEmail='".$info['faccEmail'] ."'and recStatus ='unreceived'";
$query = "select SID from AdminP where advisor=$fid ";


//run the query grab the result set
$result = mysql_query($query)
    or die('Add Advisee:Error querying database.'.$query);



//grab the result array
echo "<h5>Your advising students:</h5>";
echo "<form method ='post' action='advise.php?fid=".$fid."'>";
echo '<select size ="10" name="SID">';
echo "<option selected>None";

while($row = mysql_fetch_assoc($result))
{
    
    $query = "select * from Personal_info where studentid=".$row['SID'];
    $result2 = mysql_query($query)
        or die('fetch students error'.$query);

    while ($student=mysql_fetch_assoc($result2))
    {
        $sid = $student['studentid']; 
        $name = $student['name']." ".$student['last_name'];
        echo "<option value=$sid>$name";
	$i++;
    }
}
echo '</select><br>';
echo '<input type="submit" value="See Student" name="submit" />';

echo "</form></td></tr><tr><td></td><td>";

}


function addRecommends(){
//creates the form to add students who need to be recommended
 global $fid;
$info = getFacName();

//query to retrieve students SIDs and names
//$query = "Select * from Recommendation where recFirstName = '".$info['faccFirstName']."' and recLastName='".$info['faccLastName']."' and recEmail='".$info['faccEmail'] ."'and recStatus ='unreceived'";
$query = "select * from Recommendation where FID= $fid and recStatus='unreceived'";

//run the query grab the result set
$result = mysql_query($query)
    or die('Recommended Names:Error querying database.'.$query);



//grab the result array
echo "<h5>Recommendation Students:&emsp;</h5>";
echo "<form method ='post' action='../Recommendation/rec.php?fid=".$fid."'>";
echo '<select size ="10" name="SID">';
echo "<option selected>None";

while($row = mysql_fetch_assoc($result))
{
    
    $query = "select * from Personal_info where studentid=".$row['SID'];
    $result2 = mysql_query($query)
        or die('fetch students error'.$query);

    while ($student=mysql_fetch_assoc($result2))
    {
        $sid = $student['studentid']; 
        $name = $student['name']." ".$student['last_name'];
        echo "<option value=$sid>$name";
	$i++;
    }
}
echo '</select><br>';
echo '<input type="submit" value="Recommend Student" name="submit" />';

echo "</form></td></tr><tr><td></td><td>";

$stat = $_GET['stat'];
echo "<p> Change Password<br>Password limit: 10 characters</p>";
if($stat=="nomatch")
{
    echo "<p><font color ='FF0000'> Passwords do not match! Please try again!</font></p>";
}
else if($stat == "badpass")
{
    echo "<p><font color='FF0000'> Old Password incorrect</font></p>";

}
else if ($stat == "success")
{
    echo "<p><font color ='00CC33'>Password Updated!! </font> </p>";
}


echo '<form method="post" action="passwordChange.php">';
echo "<p><label for='pass'> Current Password:</label>";
echo "&emsp; &emsp;<input type='text' name='pass' size='10'></p>";
echo "<p> <label for='pass1'>New Password:  </label>";
echo "&emsp; &emsp;&emsp;<input type = 'text' name='pass1' size='10'></p>";
echo "<p><label for='pass2'>Confirm Password:</label>";
echo "&emsp;&emsp;<input type='text' name='pass2' size='10'></p>";

echo "<input type='hidden' name='sid' value=$fid>";
echo "<input type='hidden' name='url' value='faculty.php'>";
echo "<input type='hidden' name='type' value='faculty'>";
echo "<input type='submit' value='Change Password' name=chPass'/></form>";
echo '</form>';



echo "<br><br><a href='start.html'>Log Out</a><br><br>";

}


?>
</td>
</tr>
</table>
    </body>
</html>

