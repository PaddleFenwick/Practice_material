
<?php 
#$dbUser = "lucasch";
#$dbPass = "iamadmin";
#$dbName = "termProject";
//datbase login info
#include ($_SERVER['DOCUMENT_ROOT']."/database.php");
#include ("database.php");
include("../database.php");
#echo $_SERVER['DOCUMENT_ROOT']."<BR>";
$username= $_POST['user'];
$password= $_POST['pass'];

//check if user is in the table and return their association type
function checkUser($user , $pass)
{
    global $dbUser, $dbPass, $dbName;
//    echo $_SERVER['DOCUMENT_ROOT']."<br>";
  //  echo $dbUser.$dbPass.$dbName;
    //connect to the database
    $dbc = mysql_connect("localhost",$dbUser,$dbPass)
        or die('Error connecting to Mysql server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);
    //query to check given data against data in the table
    $query = "Select userType from Login where SID=".$user." and password='".$pass."'";
    
    //run the query
    $result = mysql_query($query)
        or die('Error querying database');
    $resultSet = mysql_fetch_array($result);
    $status ='';
    if ($resultSet['userType']=='student')
    {
        $query = "select name, last_name, status from Personal_info where studentid=$user";
    
        $resulting = mysql_query($query)
            or die('Error querying database.' );

        $students = mysql_fetch_array($resulting);

        $fname= $students['name'];
        $lname = $students['last_name'];
        $status = $students['status'];
    }
    else if($resultSet['userType']=='faculty' || $resultSet['userType']=='advisor' || $resultSet['userType']=='gs')
    {
        $query = "select fname, lname from professors where PID=$user";
    
        $resulting = mysql_query($query)
            or die('Error querying database.' );

        $students = mysql_fetch_array($resulting);

        $fname= $students['fname'];
        $lname = $students['lname'];
        
    
        
    }

    if($resultSet['userType']==NULL)
    {
        header('Location:error.html');
    }
    else {
    //$resultSet = mysql_fetch_array($result);
    	 if($status == 'student hold')
	{
	  echo "You have a hold on your account. You are unable to register for classes.";
          echo "<a href='start.html'>Click to go back</a>";
	}
        else if($resultSet['userType']=='student' && $status<>'student')
        {

          // header('Location:/application/application.html');
           header('Location:student.php?sid='.$user);
        }
        else if($resultSet['userType']=='student' && $status=='student')
        {
            header('Location:../enroll11.php?SID='.$user.'&fname='.$fname.'&lname='.$lname);
        }
        else if($resultSet['userType']=='faculty' || $resultSet['userType']=='advisor')
        {
           header('Location:../facultystart.php?SID='.$user.'&fname='.$fname.'&lname='.$lname);
        }
        else if($resultSet['userType']=='gs')
        {
           header('Location:../gsstart.php?SID='.$user.'&fname='.$fname.'&lname='.$lname);
        }
	else if($resultSet['userType']='dbadmin')
	{
	header('Location:../dbAdmin.php');
	}
     }
}


$type = checkUser($username, $password);



mysql_close($dbc);




?>
