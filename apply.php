<?php
include("connect_db.php");
session_start();
?>
<?php

if ($_SESSION["name"] == "") {
  header("location:index.php");
}
?>

<?php
$title = $_GET['s_title'];
$p_id = $_GET['id'];
$uid = $_SESSION["id"];

$sql1 = mysqli_query($con, "SELECT * FROM `Job_Posts` WHERE `Post_ID`='$p_id'");
while ($row1 = mysqli_fetch_array($sql1)) {
  $emp = $row1["Emp_ID"];
  $job_title = $row1["Job_Title"];
}
$sql = mysqli_query($con, "INSERT INTO `Applications` (`Post_ID`, `Emp_ID`, `User_ID`, `Time`, `Status`) VALUES('$p_id', '$emp', '$uid', now(), 'Pending')");
if ($sql) {
  echo '<script>alert("Your application was sent. Thank You!");</script>';
  header("location:user.php");
}
?>
