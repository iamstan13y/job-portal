<?php
include("connect_db.php");
?>
<?php
session_start();
if ($_SESSION['name'] == '') {
	header('location:index.php');
}

?>

<script>
	function delete_application(id) {
		if (confirm("You want to delete your application?")) {
			window.location.href = 'user_delete_app.php?yesdelete=' + id;
		}
	}
</script>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title><?php echo $_SESSION['name']; ?> | My Applications</title>

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

						<a href="notification.php" class="list-group-item active" style="background-color:black;">
							My Applications(<?php echo $count; ?>)
						</a>

						<a href="changepass.php" class="list-group-item">Change Password
						</a>
						<a href="logout.php" class="list-group-item">Log Out
						</a>
					</div>
				</div>

				<div class="col-lg-8">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped" style="background-color:#FFF">
							<tr class="active">
								<th style="text-align:center">No.</th>
								<th style="text-align:center">Institution</th>
								<th style="text-align:center">Job Title</th>
								<th style="text-align:center">Date</th>
								<th style="text-align:center">Status</th>
								<th style="text-align:center">Delete</th>
							</tr>
							<?php

							$uid = $_SESSION["id"];
							$sql1 = "SELECT * FROM `Applications` WHERE `User_ID`='$uid'";

							$re = mysqli_query($con, $sql1);
							$count = mysqli_num_rows($re);
							$i = 1;

							while ($row = mysqli_fetch_array($re)) {
								$app_id = $row["App_ID"];
								$po_id = $row["Post_ID"];
								$user_id = $row["User_ID"];
								$emp_id = $row["Emp_ID"];
								$time = $row["Time"];
								$status = $row["Status"];
								$post_id = $_SESSION["id"];

								$sql1 = "SELECT * FROM `Job_Posts` WHERE `Post_ID`='$po_id'";
								$res = mysqli_query($con, $sql1);

								if ($row1 = mysqli_fetch_array($res)) {
									$job_title = $row1["Job_Title"];
								}

								echo '<tr class="default">';
								echo '<td style="text-align:center">' . $i . '</td>';

								$emp = mysqli_query($con, "SELECT * FROM `Employer_Details` WHERE `Emp_ID`='" . $emp_id . "'");
								$empRes = mysqli_fetch_array($emp);

								echo '<td>' . $empRes['Name'] . '</td>';
								echo '<td>' . $job_title . '</td>';
								echo '<td>' . $time . '</td>';
								echo '<td>' . $status . '</td>';
								echo '<td><a href="javascript:delete_application(' . $app_id . ')" class="btn btn-danger">delete</a></td>';
								echo '</tr>';
								$i++;
							}
							?>

						</table>
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