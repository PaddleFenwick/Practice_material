<?php

include('../database.php');

$dbc = mysql_connect("localhost", $dbUser, $dbPass)
    or die('Error connecting to mysql server');

mysql_select_db($dbName,$dbc);

$SID = $_POST['SID'];

echo "SID IS $SID";
$query = "update Personal_info set status='student' where studentid=$SID";

mysql_query($query)
    or die('Error running query to update personal status'.$query);

$query = "Update AcademicInfo set admitStatus='student' where SID=$SID";

mysql_query($query)
    or die('Error running query to update academic status');

mysql_close($dbc);


echo '<h5> Thanks for commiting to GWU!</h5>';
echo '<h3> <a href="start.html"> Click to log out!!</a></h3>';



?>
