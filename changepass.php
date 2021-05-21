<?php
include("connect_db.php");
session_start();
?>

<?php
if ($_SESSION['name'] == '') {
  header('location:index.php');
}
?>

<?php
extract($_POST);
if (isset($updpass)) {
  $em = $_SESSION["email"];

  $query = mysqli_query($con, "SELECT * FROM `Job_Seekers` WHERE `Email`='$em' AND `Password`='$op'");
  $row = mysqli_num_rows($query);

  if ($row) {
    if ($np == $cp) {
      mysqli_query($con, "UPDATE `Job_Seekers` SET `Password`='$np' WHERE `Email`='$em'");

      $msg = "<font color='green'>Password Updated Successfully !</font>";
    } else {
      $msg = "<font color='red'>New and Confirmed Passwords Don't Match!</font>";
    }
  } else {
    $msg = "<font color='red'>Old Password is Wrong!</font>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title><?php echo $_SESSION['name']; ?> | Change Password</title>

  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="components/bootstrap/dist/js/jquery.js"></script>

  <link href="components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="components/bootstrap/dist/css/simple-sidebar.css" rel="stylesheet">
  <link href="components/bootstrap/dist/css/postmodal.css" rel="stylesheet">
  <link href="components/bootstrap/dist/css/fbbox.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <label class="navbar-text text-center text-primary" style="vertical-align:10px;font-size:medium ">MyDashboard | <font style="font-size:13px">Howdy, <?php echo $_SESSION["name"]; ?>!</font></label>
      <?php include("header.php"); ?>
    </div>
  </nav>

  <br /><br /><br />
  <div class="fluid-container">
    <div class="row" style="clear:both">
      <div class="col-lg-12">
        <div class="col-lg-4">
          <div class="list-group" style="margin-left:0px">

            <a href="user.php" class="list-group-item">
              Job Posts</a>

            <a href="myprofile.php" class="list-group-item">My Profile
            </a>

            <a href="notification.php" class="list-group-item">
              My Applications(<?php echo $count; ?>)
            </a>

            <a href="changepass.php" class="list-group-item active" style="background-color:black;">Change Password
            </a>
            <a href="logout.php" class="list-group-item">Log Out
            </a>
          </div>
        </div>

        <div class="col-lg-8">

          <div class="center">
            <div class="posts">
              <div class="create-posts">
                <div class="col-sm-10 well">
                  <form method="post">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo @$msg; ?></label>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Old Password</label>
                      <input type="password" class="form-control" value="<?php echo @$op; ?>" name="op" id="exampleInputPassword1" placeholder="Old Password" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">New Password</label>
                      <input type="password" value="<?php echo @$np; ?>" class="form-control" name="np" id="exampleInputPassword1" placeholder="New Password" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Confirm Password</label>
                      <input type="password" value="<?php echo @$cp; ?>" class="form-control" name="cp" id="exampleInputPassword1" placeholder="Confirm Password" required>
                    </div>

                    <br />
                    <div class="form-group">
                      <button name="updpass" class="btn  btn-success" type="submit">Update Password</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script src="components/bootstrap/dist/js/bootstrap.min.js"></script>

      <script>
        $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
        });
      </script>

      <script type="text/javascript">
        $(document).ready(function() {
          $('.status').click(function() {
            $('.arrow').css("left", 0);
          });
          $('.photos').click(function() {
            $('.arrow').css("left", 146);
          });
        });
      </script>
</body>

</html>