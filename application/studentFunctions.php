<?php

   # $dbUser= "lucasch";
   # $dbPass= "iamadmin";
   # $dbName = "termProject";


//function to print out their application status
function printStatus(){
    
    global $dbUser, $dbPass, $dbName, $sid, $dbServer, $transcriptStat, $recStat; 
    //open the database connection
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);

    //query to select data from personal info table
    $query = "select transcriptStatus, recStatus from AcademicInfo where SID='$sid'";

    //run the query and grab the result
    $result = mysql_query($query)
        or die('Status: Error Querying Database');

    //displays the status of recommendations
    $data = mysql_fetch_array($result);
    $recStatus = $data['recStatus'];
    if($recStatus=='unreceived')
    {
        echo "<tr><td><h4>Current Recommendation Status: Unreceived 0/2</h4></td></tr>";
        $recStat="unreceived";
    }
    else if($recStatus=='received')
    {
        echo "<tr><td><h4>Current Recommendation Status: Received 2/2</h4></td></tr>";
        $recStat = "received";
    }
    else if($recStatus=='incomplete')
    {
        echo "<tr><td><h4>Current Recommendation Status: Received 1/2</h4></td></tr>";
        $recStat = "incomplete";
    }
    
    //displays the status of the transcipts
    $transStatus = $data['transcriptStatus'];
    if($transStatus=='unreceived')
    {
        echo "<tr><td><h4>Current Transcript Status: Unreceived</h4></td></tr>";
        $transcriptStat = "unreceived";
    }
    else if($transStatus=='received')
    {
        echo "<tr><td><h4>Current Transcript Status: Received</h4></td></tr>";
        $transcriptStat = "received";
    }
}



//function to print out their application status
function printAppStatus(){
    
    global $dbUser, $dbPass, $dbName, $sid, $dbServer, $recStat,  $transcriptStat; 
    //open the database connection
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);

    //query to select data from personal info table
    $query = "select status from Personal_info where studentid='$sid'";
    //$query = "select admitStatus,transcriptStatus, recStatus from AcademicInfo where SID=$sid ";

    //run the query and grab the result
    $result = mysql_query($query)
        or die('AppStatus: Error Querying Database');

    $data = mysql_fetch_array($result);
    $status = $data['status'];
    //$rec = $data['recStatus'];
    //$tran = $data['transcriptStatus'];
    echo "<tr><td><h3>Current Application Status:</h3>";
    if($status=='applicant' && $transcriptStat=='received' && $recStat=='received')
    {
        echo "<h3>Application Complete and Under Review/ No Decision Yet.</h3></td></tr>";
    }
    else if($status=='reject')
    {
        echo "<h3>Your application for admission has been denied.</h3></td></tr>";
    }
    else if($status=='admit')
    {
        echo "<h3>Congratulations you have been admitted. The formal letter of acceptance will be mailed.</h3>
            <p>We would like to offer you admission to the GW Masters Program. In order to commit to GW please Press the Accept button below.
            If you would like to refuse the offer please press the reject button. Have a great Day! </p>";
        
        echo "</td></tr>";
    }
    else if($status=='pending' || $transcriptStat<>'unreceived' || $recStat<>'received')
    {
        echo "<h3>Application Incomplete.</h3><h3> Missing Items:</h3><ul>";
        if($transcriptStat == "unreceived")
        {
            echo "<li>Missing transcript</li>";
        }
        if($recStat == "unreceived")
        {
            echo "<li> Missing Two Recommendations</li>";
        }
        else if ($recStat == "incomplete")
        {
            echo "<li>Missing One Recommendation</li>";
        }
        echo "</ul></td></tr>";
    }
}

//function to print out the personal information of the applicant
function printPersonal(){
    
    global $dbUser, $dbPass, $dbName, $sid, $dbServer; 
    //open the database connection
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);

    //query to select data from personal info table
    $query = "select * from Personal_info where studentid='$sid'";

    //run the query and grab the result
    $result = mysql_query($query)
        or die('Personal: Error Querying Database');
    
    //get results of the query and assign to variables
    $resultSet = mysql_fetch_array($result);
    $firstName = $resultSet['name'];
    $lastName = $resultSet['last_name'];
    
    echo "<tr><td>Name:&nbsp;&nbsp;&nbsp;<u>$firstName&nbsp;$lastName</u><br>";
    echo "Student Number:&nbsp;&nbsp;<u>$sid</u><br></td></tr>";
    

    //close database
    mysql_close($dbc);
}

//function to print out the prospective students academic info
function printAcademic(){
    global $dbUser, $dbPass, $dbName, $sid,$dbServer; 

    //open database connection
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //selects the database
    mysql_select_db($dbName,$dbc);

    //run the query to select the students academic info
    $query = "select * from AcademicInfo where SID='$sid'";

    //run the query and grab result set
    $result = mysql_query($query)
        or die('Academic info: Error Querying Database');
    
    $info = mysql_fetch_array($result);

    //extra space for the degree heading
    echo "<tr><td>Semester and Year of Application: <u>".$info['admitSem'];
    echo "&nbsp;".$info['admitYear']."</u>";
    echo "<br><br><br></td></tr>";
    //code to display what degree they are searching for
    echo "<tr><td><font size='4'><b>Applying for Degree:</b></font><br><br>";
    if($info['degree']=="M.S.")
    {
        echo "M.S.&nbsp;<u>&emsp;<font Size='3'>X</font>&emsp;</u>&emsp;";
        echo "&emsp;&emsp;Ph.D.<u>&emsp;&nbsp;&emsp;</u>";
    }else {
        echo "M.S.&nbsp;<u>&emsp;&nbsp;&emsp;</u>&emsp;&emsp;&emsp;";
        echo "Ph.D.<u>&emsp;<font size='3'>X</font>&emsp;</u>";
    }
    echo "</td></tr>";
    echo "<tr><td><font size='5'><b><i>Summary of Applicant Credentials:</i><b></font></td></tr>";
    
    echo "<tr><td>";
    //displays their areas of interest
    echo "<font size ='4'><b>Areas of Interest:</b></font><br>";
    echo "<p>".$info['areaInterest']."</p>";
    
    //displays their work experience
    echo "<font size ='4'><b>Experience:</b></font><br>";
    echo "<p>".$info['priorWork']."</p>";
    echo "</td></tr>";
    
    //close the database
    mysql_close($dbc);
}

function printScores(){
    global $dbUser, $dbPass, $dbName, $sid,$dbServer; 

    //connect to the database
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);
    
    //create the query to get test scores
    $query = "select * from greScores where SID='$sid'";
    
    //run the query and collect the resultset
    $result = mysql_query($query)
        or die('Test Scores: Error Querying Database');
    
    //get actual array of data from result set
    $info = mysql_fetch_array($result);

    //prints out previous test score info
    echo "<tr><td>";
    echo "<b>GRE:</b>&emsp;Total Score:&nbsp;<b>".$info['total'];
    echo "</b>&emsp;&emsp;Verbal:&nbsp;<b>".$info['verb']."</b>&emsp;&emsp;";
    echo "Analytical:&nbsp;<b>".$info['analytical']."</b>&emsp;&emsp;";
    echo "Quantitative:&nbsp;<b>".$info['quantitative']."</b>&emsp;&emsp;";
    echo "<br><br>Date of GRE Exam:&emsp;".$info['greDate']."<br>";
    echo "<br><b>GRE Advanced:</b>&emsp;&emsp;";
    echo "Score:&nbsp;<b>".$info['advancedScore']."</b>&emsp;&emsp;";
    echo "Subject:&nbsp<b>".$info['advancedSubject']."</b><br>";
    echo "<br><b>TOEFL</b>&emsp;&emsp;&emsp;";
    echo "Score:&nbsp;<b>".$info['toeScore']."</b>&emsp;&emsp;";
    echo "Date of TOEFL Exam:&nbsp;<b>".$info['toeDate']."</b><br>";
    echo "</tr></td>";

}

//function to print prior degree information
function printPriors()
{
    global $dbUser, $dbPass, $dbName, $sid,$dbServer; 

   //connect to the database 
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the specific database
    mysql_select_db($dbName,$dbc);
    
    //create query to select data from the prior degree table
    $query = "select * from priorDegrees where SID='$sid'";
    
    //run the query and collect the results set
    $result = mysql_query($query)
        or die('Prior Degrees: Error Querying Database');

    echo "<tr><td><font size='4'><b>Prior Degrees:</b></font><br>";
    //while their is a row left loop
    while($degrees = mysql_fetch_assoc($result))
    {
        if($degrees['priorDegree']!=null)
        {
        echo "<p>";
        echo "Degree:&nbsp;".$degrees['priorDegree']."&emsp;&emsp;&emsp;&emsp;";     
        echo "GPA:&nbsp;".$degrees['gpa']."&emsp;&emsp;&emsp;&emsp;";     
        //echo "Major:&nbsp;".$degrees['']."&emsp;&emsp;&emsp;&emsp;";     
        echo "Major:&nbsp;"."Computer Science&emsp;&emsp;&emsp;&emsp;";     
        echo "Year:&nbsp;".$degrees['year']."&emsp;&emsp;&emsp;&emsp;";     
        echo "University:&nbsp;".$degrees['university']."&emsp;&emsp;&emsp;&emsp;";     
        echo "</p>";
        }
    } 
    echo "</td></tr>";

}

function printAdvisors(){
    global $dbUser, $dbPass, $dbName, $sid,$dbServer; 
    
    $dbc = mysql_connect($dbServer, $dbUser, $dbPass)
        or die('Error connecting to MySQL server.');
    
    //select the database
    mysql_select_db($dbName,$dbc);
    
    //create the query to get test scores
    $query = "select * from Faculty";
    
    //run the query and collect the resultset
    $result = mysql_query($query)
        or die('Advisors: Error Querying Database');
    
    echo "Please Suggest an Advisor:";
    echo "<select name='advisor'>";
    echo "<option value='none' selected>Select Advisor";
    while($faculty = mysql_fetch_assoc($result))
    {
        $lastname = $faculty['faccLastName'];
        $firstname = $faculty['faccFirstName'];
        $fid = $faculty['FID'];
        echo "<option value='".$fid."'>$firstname $lastname";
    }
    echo "</select><br><br><br><br>";
    echo "<input type='submit' value='Submit' name='submit' />";
    echo "</form>";


}

function printPasswordChange(){

    global $sid;
    $stat = $_GET['stat'];
    echo "<p>To change your password please enter your current password and your new password. Limit 10 characters</p>";
    if($stat == "nomatch")
    {
        echo "<p><font color ='FF0000'>Passwords do not match! Please try again!</font></p>";
    } 
    else if($stat == "badpass")
    {
        echo "<p><font color = 'FF0000'> Old Password incorrect</font></p> ";
    }
    else if($stat == "success")
    {
        echo "<p><font color ='00CC33'>Password updated!!</font> </p>";
    }
    echo "<form method='post' action='passwordChange.php'> ";
    echo "<p><label for='pass'>Current Password:</label>";
    echo "<input type='text' name='pass' size='10'></p>";
    echo "<p><label for='pass1'>New Password:</label>";
    echo "<input type='text' name='pass1' size='10'>";
    echo "<label for='pass2'>Confirm Password:</label>";
    echo "&emsp; &emsp;<input type='text' name='pass2' size='10'></p>";
    echo "<input type='hidden' name='sid' value=$sid>";
    echo "<input type='hidden' name='url' value='student.php'>";
    echo "<input type='hidden' name='type' value='student'>";
    echo "<input type='submit' value='change' name=chPass'/></form>";
}


?>
