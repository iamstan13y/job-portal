<?php
include("connect_db.php");
?>
<?php
if (isset($_GET["yesdelete"])) {

    $del_id = $_GET["yesdelete"];
    $result = mysqli_query($con, "DELETE FROM `Applications` WHERE `App_ID`='$del_id'");

    if ($result) {
        echo '<script>alert("Application Deleted!");<script>';
        header("location:notification.php");
    }
}

?>