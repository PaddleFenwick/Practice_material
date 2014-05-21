<?php 
//file to submit password and if not equal then redirect back to page

$pass = $_POST['pass'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$SID = $_POST['sid'];
$url = $_POST['url'];
$type = $_POST['type'];
include("../database.php");
if($pass1 == $pass2)
{
    global $dbUser, $dbPass, $dbName;
    $dbc = mysql_connect("localhost", $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);
    
    //query to check if users password is correct
    $query = "select password from Login where SID=$SID";

    $result = mysql_query($query)
      or die("Error querying database query failed: ".$query);

    $resultset = mysql_fetch_array($result);

    if($resultset['password']==$pass)
    {
        $query = "update Login set password='$pass1' where SID=$SID";
        $result = mysql_query($query)
            or die('Error querying the database query is '.$query);
        $stat = "success";
    }
    else $stat = "badpass";
}
else $stat = "nomatch";

if ($type == 'student')
{
    header('Location:'.$url.'?sid='.$SID.'&stat='.$stat);
}
else if ($type =='faculty')
{
    header('Location:'.$url.'?fid='.$SID.'&stat='.$stat);
}




?>
