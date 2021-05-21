<?php
session_start();

include("connect_db.php");
?>
<?php

if ($_SESSION['name'] == '') {
	header('location:index.php');
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

	<title><?php echo $_SESSION['name']; ?> | Employer Profile</title>

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

						<a href="user.php" class="list-group-item active" style="background-color:black;">
							Job Posts</a>

						<a href="myprofile.php" class="list-group-item">My Profile
						</a>

						<a href="notification.php" class="list-group-item">
							My Applications(<?php echo $count; ?>)
						</a>

						<a href="changepass.php" class="list-group-item">Change Password
						</a>
						<a href="logout.php" class="list-group-item">Log Out
						</a>
					</div>
				</div>

				<div class="col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h1 class="text-left text-primary"> Employer Profile</h1>
						</div>
						<?php
						$myid = $_REQUEST['userid'];
						?>
						<?php

						$sql = "SELECT * FROM `Employer_Details` WHERE `Emp_ID`='" . $myid . "'";

						$result = $con->query($sql);

						if ($result->num_rows > 0) {

							while ($row = $result->fetch_assoc()) {

								echo "<div class='col-md-4 panel panel-default'>";
								echo "<img src='profile_images/" . $row['Logo'] . "' style='width:250px;height:250px' class='img img-circle'></div>";

								echo "<div class='col-md-8 panel panel-default' style='width:300;height:250px''><br/>";

								echo "<h4><label> Institution </label>: ";
								echo "<label>" . $row['Name'] . " </label></h4><hr/>";
								echo "<h4><label> Address </label>: ";
								echo "<label>" . $row['Address'] . " </label></h4><hr/>";
								echo "<h4><label> Email: </label>	";
								echo "<label>" . $row['Email'] . "</label></h4><hr/>";
								echo "<h4><label> Mobile:  </label>	";
								echo "<label>" . $row['Phone_Number'] . "</label></h4><hr/>";
						?>
					</div>
				</div>
			</div>
		</div>

<?php }
						} ?>
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