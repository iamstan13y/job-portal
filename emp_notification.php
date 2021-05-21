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
		if (confirm("You're about to delete a job application! Continue?")) {
			window.location.href = 'delete_app.php?yesdelete=' + id;
		}
	}
</script>

<script>
	function approve_application(id) {
		if (confirm("Approve this job application?")) {
			window.location.href = 'approve_app.php?approve=' + id;
		}
	}
</script>

<script>
	function cancel_application(id) {
		if (confirm("Cancel previously approved job application?")) {
			window.location.href = 'approve_app.php?cancel=' + id;
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

	<title><?php echo $_SESSION['name']; ?> | Notifications</title>

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
			<div id="navbar" class="navbar-collapse collapse">
				<label class="navbar-text text-center text-primary" style="vertical-align:10px;font-size:medium ">Employer Dashboard | <font style="font-size:13px"> <?php echo $_SESSION["name"]; ?></font> </label>
				<?php include("emp_header.php"); ?>
			</div>
	</nav>

	<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="lineModalLabel">Post New Job!</h3>
				</div>
				<div class="modal-body">

					<form action="" method="post" enctype="multipart/form-data">

						<div class="form-group">
							<label for="job_title">Job Title</label>
							<textarea name="job_title" class="form-control" placeholder="e.g. O-Level English Teacher"></textarea>
						</div>

						<div class="form-group">
							<label for="job_description">Job Description & Requirements</label>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<textarea style="resize:vertical;" class="form-control" placeholder="Description..." rows="6" name="job_desc" required></textarea>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<div class="btn-group btn-group-justified" role="group" aria-label="group button">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
								</div>
								<div class="btn-group btn-delete hidden" role="group">
									<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">Delete</button>
								</div>
								<div class="btn-group" role="group">
									<button type="submit" name="submit" class="btn btn-default btn-hover-green" value="Post">Post</button>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	</form>

	<br /><br /><br />
	<div class="fluid-container">
		<div class="row" style="clear:both">
			<div class="col-lg-12">
				<div class="col-lg-4">
					<div class="list-group" style="margin-left:0px">

						<a href="employer.php" class="list-group-item">
							My Job Posts</a>

						<a href="" data-toggle="modal" data-target="#squarespaceModal" class="list-group-item">
							Post Job
						</a>

						<a href="emp_notification.php" class="list-group-item active" style="background-color:black;">
							Notification(<?php echo $count; ?>)
						</a>

						<a href="emp_changepass.php" class="list-group-item">Change Password
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
								<th style="text-align:center">Applicant</th>
								<th style="text-align:center">Job Title</th>
								<th style="text-align:center">Date</th>
								<th style="text-align:center">Status</th>
								<th style="text-align:center">Approve</th>
								<th style="text-align:center">Delete</th>
							</tr>
							<?php

							$uid = $_SESSION["id"];
							$sql1 = "SELECT * FROM `Applications` WHERE `Emp_ID`='$uid'";

							$re = mysqli_query($con, $sql1);
							$count = mysqli_num_rows($re);
							$i = 1;

							while ($row = mysqli_fetch_array($re)) {
								$app_id = $row["App_ID"];
								$po_id = $row["Post_ID"];
								$user_id = $row["User_ID"];
								$emp_id = $row["Emp_ID"];
								$status = $row["Status"];
								$time = $row["Time"];
								$post_id = $_SESSION["id"];

								$sql1 = "SELECT * FROM `Job_Posts` WHERE `Post_ID`='$po_id'";
								$res = mysqli_query($con, $sql1);

								if ($row1 = mysqli_fetch_array($res)) {
									$job_title = $row1["Job_Title"];
								}

								echo '<tr class="default">';
								echo '<td style="text-align:center">' . $i . '</td>';

								$user = mysqli_query($con, "SELECT * FROM `Job_Seekers` WHERE `User_ID`='" . $user_id . "'");
								$userRes = mysqli_fetch_array($user);

								echo '<td>' . $userRes['Firstname'] . ' ' . $userRes['Lastname'] . '</td>';
								echo '<td>' . $job_title . '</td>';
								echo '<td>' . $time . '</td>';
								echo '<td>' . $status . '</td>';
								if ($status != "Approved") {
									echo '<td><a href="javascript:approve_application(' . $app_id . ')" class="btn btn-success">Approve</a></td>';
								} else {
									echo '<td><a href="javascript:cancel_application(' . $app_id . ')" class="btn btn-warning">Disprove</a></td>';
								}
								echo '<td><a href="javascript:delete_application(' . $app_id . ')" class="btn btn-danger">Delete</a></td>';
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