<?php
require 'connect_db.php';

$uid = $_SESSION["id"];
$sql1 = "SELECT * FROM `Applications` WHERE `User_ID`='$uid'";
$re = mysqli_query($con, $sql1);
$count = mysqli_num_rows($re);
?>
<ul class="nav navbar-nav navbar-right">
    <li><a href="notification.php"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> My Applications(<?php echo $count; ?>) </a></li>
    <li><a href="logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Log Out</a></li>
</ul>