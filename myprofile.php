<?php
include("connect_db.php");
?>
<?php
session_start();

if ($_SESSION['name'] == '') {
	header('location:index.php');
}

?>

<?php
if (isset($_POST["update"])) {
	$skills = $_POST["skills"];
	$quals = $_POST["quals"];
	$sql = mysqli_query($con, "UPDATE `Job_Seekers` SET `Skills`='" . $skills . "', `Qualifications`='" . $quals . "' WHERE `User_ID`='" . $_SESSION['id'] . "'");

	if ($sql) {
		echo '<script>alert("Profile Updated Successfully!");</script>';
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

	<title><?php echo $_SESSION['name']; ?> | My Profile</title>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="components/bootstrap/dist/js/jquery.js"></script>

	<!-- Bootstrap core CSS -->
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

						<a href="myprofile.php" class="list-group-item active" style="background-color:black;">My Profile
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
							<h4 font style="color: blue">MY PROFILE</h4>
						</div>

						<?php
						$sql = "SELECT * FROM `Job_Seekers` WHERE `User_ID`='" . $_SESSION['id'] . "'";

						$result = $con->query($sql);

						if ($result->num_rows > 0) {

							while ($row = $result->fetch_assoc()) {

								echo "<div class='col-md-4 panel panel-default'>";
								echo "<img src='profile_images/" . $row['Image'] . "' style='width:400;height:250px'class='img img-thumbnail'></div>";
								echo "<div class='col-md-8 panel panel-default' style='width:300;height:250px'><br/>";
								echo "<label> NAME </label> <br/>";
								echo "<label><h4>" . $row['Firstname'] . " " . $row["Lastname"] . "</h4></label><br/><br/>";
								echo "<label> EMAIL </label><br/>";
								echo "<label><h4>" . $row['Email'] . "</h4></label><br/>";
								echo "<label> PHONE NUMBER </label> <br/>";
								echo "<label><h4>" . $row['Phone_Number'] . "</h4></label><br/><br/>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<div class="row" style="clear:both">
			<div class="col-lg-12">
				<div class="col-lg-4">
				</div>
				<div class="col-lg-8">
					<div class="panel panel-default">
						<?php
						$sql = mysqli_query($con, "SELECT * FROM `Job_Seekers` WHERE `User_ID`='" . $_SESSION['id'] . "'");
						$res = mysqli_fetch_array($sql);

						?> <form method="post">
							<div class="panel-heading">
								<h4 font style="color: blue">TECHNICAL SKILLS:</h4>
							</div>
					</div><label></label>
					<textarea name="skills" rows='5' cols="100" placeholder="Enter Your Skills..."><?php echo $res['Skills']; ?></textarea>
					<br /><br />
					<label>
						<h4 font style="color: blue">QUALIFICATIONS:</h4>
					</label><br>
					<textarea name="quals" rows='4' cols="100" placeholder="Enter your Details about your proejcts here"><?php echo $res['Qualifications']; ?></textarea>
					<br /><br />
					<input type="submit" name="update" class="btn btn-primary" value="Update Profile">
				</div>
			</div>
			</form>
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