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
function timeAgo($time_ago)
{

	$time_ago = strtotime($time_ago);
	$cur_time   = (time() + 3600);
	$time_elapsed   = $cur_time - $time_ago;
	$seconds    = $time_elapsed;
	$minutes    = round($time_elapsed / 60);
	$hours      = round($time_elapsed / 3600);
	$days       = round($time_elapsed / 86400);
	$weeks      = round($time_elapsed / 604800);
	$months     = round($time_elapsed / 2600640);
	$years      = round($time_elapsed / 31207680);
	// Seconds
	if ($seconds <= 60) {
		return "just now";
	}
	//Minutes
	else if ($minutes <= 60) {
		if ($minutes == 1) {
			return "1 minute ago";
		} else {
			return "$minutes minutes ago";
		}
	}
	//Hours
	else if ($hours <= 24) {
		if ($hours == 1) {
			return "an hour ago";
		} else {
			return "$hours hours ago";
		}
	}
	//Days
	else if ($days <= 7) {
		if ($days == 1) {
			return "Yesterday";
		} else {
			return "$days days ago";
		}
	}
	//Weeks
	else if ($weeks <= 4.3) {
		if ($weeks == 1) {
			return "Last week";
		} else {
			return "$weeks weeks ago";
		}
	}
	//Months
	else if ($months <= 12) {
		if ($months == 1) {
			return "Last month";
		} else {
			return "$months months ago";
		}
	}
	//Years
	else {
		if ($years == 1) {
			return "Last year";
		} else {
			return "$years years ago";
		}
	}
}
?>

<?php
if (isset($_POST["submit"])) {
	$job_title = $_POST["job_title"];
	$job_desc = $_POST["job_desc"];
	$emp_id = $_SESSION["id"];

	$sql = mysqli_query($con, "INSERT INTO `Job_Posts` (`Emp_ID`, `Job_Title`, `Description`, `Post_Time`) 
						 VALUES('$emp_id','$job_title','$job_desc' ,now());");

	if ($sql) {
		echo '<script>alert("New Job Post Successful!");</script>';
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

	<title><?php echo $_SESSION['name']; ?> | Job Posts</title>

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

						<a href="employer.php" class="list-group-item active" style="background-color:black;">
							My Job Posts</a>

						<a href="" data-toggle="modal" data-target="#squarespaceModal" class="list-group-item">
							Post Job
						</a>

						<a href="emp_notification.php" class="list-group-item">
							Notification(<?php echo $count; ?>)
						</a>

						<a href="emp_changepass.php" class="list-group-item">Change Password
						</a>
						<a href="logout.php" class="list-group-item">Log Out
						</a>
					</div>
				</div>

				<div class="col-lg-8">
					<?php
					$num_rec_per_page = 10;
					if (isset($_GET["page"])) {
						$page  = $_GET["page"];
					} else {
						$page = 1;
					};
					$start_from = ($page - 1) * $num_rec_per_page;
					$emp_id = $_SESSION["id"];

					$sql = mysqli_query($con, "SELECT * FROM `Job_Posts` WHERE `Emp_ID`= $emp_id ORDER BY `Post_Time` DESC LIMIT  $start_from, $num_rec_per_page");
					while ($row = mysqli_fetch_array($sql)) {
						$id = $row["Post_ID"];
						$time = $row["Post_Time"];

						$sql2 = mysqli_query($con, "SELECT * FROM `Employer_Details` WHERE `Emp_ID`= $emp_id");
						while ($row2 = mysqli_fetch_array($sql2)) {
							$name = $row2["Name"];
							$img = $row2["Logo"];
						}

						echo '<div class="post-show" style="width:90%;border-radius:5px">
									<div class="post-show-inner">
										<div class="post-header">
											<div class="post-left-box">
												<div class="id-img-box"><img src="profile_images/' . $img . '"></img></div>
												<div class="id-name">
													<ul>
													<b>' . $name . '</b>
														<li><small font style="color: grey">' . timeAgo($time) . '</small></li>
													</ul>
												</div>
											</div>
											<div class="post-right-box"></div>
										</div>
											<div class="post-body">
											<div class="post-header-text"><b>' . $row['Job_Title'] . '</b>
							                 <p>' . $row['Description'] . '</p>
											 <br/><br/>';
						$sql1 = mysqli_query($con, "SELECT * FROM `Applications` WHERE `Post_ID`='$id'");
						while ($row1 = mysqli_fetch_array($sql1)) {
							$app_time = $row1["Time"];
							$user_id = $row1["User_ID"];
							$sql2 = mysqli_query($con, "SELECT * FROM `Job_Seekers` WHERE `User_ID`='$user_id'");
							while ($row2 = mysqli_fetch_array($sql2)) {
								$name =  $row2["Firstname"] . " " . $row2["Lastname"];
								$img = $row2["Image"];
								echo '<div style="margin-left:60px">
										<a href="otheruser.php?userid=' . $user_id . '"><img style="height:25px; width="25px" src="profile_images/' . $img . '"></img></a>
										&nbsp; &nbsp;<font style="font-size:13px"><a href="otheruser.php?userid=' . $user_id . '"> ' . $name . ' is interested.</a></>
										<small>' . timeAgo($app_time) . '</small> &nbsp; &nbsp; &nbsp;
											 </div>
											 <div style="margin-left:20px"><div class="id-name">
											</div>
										</div>';
							}
						}
						echo '</div></div></div></div><br/>';
					}

					$sql = "SELECT * FROM `Job_Posts` JOIN `Employer_Details` WHERE `Job_Posts`.`Emp_ID`=`Employer_Details`.`Emp_ID` ORDER BY `Job_Posts`.`Post_Time` DESC";
					$rs_result = mysqli_query($con, $sql);
					$total_records = mysqli_num_rows($rs_result);
					$total_pages = ceil($total_records / $num_rec_per_page);
					echo '<div class="col-lg-8" style="text-align:center; font-size:20px">';

					echo "<a href='employer.php?page=1'>" . '|< Prev ' . "</a> "; // Goto 1st page  

					for ($i = 1; $i <= $total_pages; $i++) {
						echo "<a href='employer.php?page=" . $i . "'>" . $i . "</a> ";
					};
					echo "<a href='employer.php?page=$total_pages'>" . ' Next >|' . "</a> "; // Goto last page
					echo '</div>';
					?>
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