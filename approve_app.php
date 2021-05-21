<?php
include("connect_db.php");
?>
<?php
if (isset($_GET["approve"])) {

    $appr_id = $_GET["approve"];
    $result = mysqli_query($con, "UPDATE `Applications` SET `Status`='Approved' WHERE `App_ID`='$appr_id'");

    if ($result) {
        echo '<script>alert("Application Approved!");<script>';
        header("location:emp_notification.php");
    }
} else if (isset($_GET["cancel"])) {
    $appr_id = $_GET["cancel"];
    $result = mysqli_query($con, "UPDATE `Applications` SET `Status`='Cancelled' WHERE `App_ID`='$appr_id'");

    if ($result) {
        echo '<script>alert("Job Application Cancelled!");<script>';
        header("location:emp_notification.php");
    }
}

?>