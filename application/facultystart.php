<html>
<style>

body
{

background-color:#ffeebb;
color:#004065;
font-family:Tahoma;
text-align:center;

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


</style>

<body>
<h2>LOG IN</h2>
<?php
$fname= $_GET['fname'];
$lname = $_GET['lname'];
$SID = $_GET['SID'];
echo '<form method="post" action = "application/faculty.php">';
echo '
<th>Review Applicants</th>
<input type="submit" value="GO TO APPLICANTS"/>

</form>
<form method="post" action = "course.php?fname='.$fname.'&lname='.$lname.'&PID='.$SID.'">
<center>';
?>
<th>Gradebook Assignment</th>
<input type="submit" value="GO GRADEBOOK"/>
</center>
</form>

</form>
</body>
</html>
