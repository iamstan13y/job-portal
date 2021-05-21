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
			<form class="navbar-form navbar-right" action="search.php" method="post">
				<div class="input-group" style="margin-right:200px">
					<input type="text" class="form-control" placeholder="Search..." id="query" name="search" value="">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</div>
			</form>
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
					<?php
					$num_rec_per_page = 10;
					if (isset($_GET["page"])) {
						$page  = $_GET["page"];
					} else {
						$page = 1;
					};
					$start_from = ($page - 1) * $num_rec_per_page;
					$sql = mysqli_query($con, "SELECT * FROM `Job_Posts` JOIN `Employer_Details` WHERE `Job_Posts`.`Emp_ID`=`Employer_Details`.`Emp_ID` ORDER BY `Job_Posts`.`Post_Time` DESC LIMIT  $start_from, $num_rec_per_page");
					while ($row = mysqli_fetch_array($sql)) {
						$id = $row["Post_ID"];
						$time = $row["Post_Time"];

						echo '<div class="post-show" style="width:90%;border-radius:5px">
									<div class="post-show-inner">
										<div class="post-header">
											<div class="post-left-box">
												<div class="id-img-box"><a href="emp_profile.php?userid=' . $row['Emp_ID'] . '"><img src="profile_images/' . $row['Logo'] . '"></a></img></div>
												<div class="id-name">
													<ul>
													<b><a href="emp_profile.php?userid=' . $row['Emp_ID'] . '">	' . $row['Name'] . '</a> </b>
														<li><small font style="color: grey">' . timeAgo($time) . '</small></li>
													</ul>
												</div>
											</div>
											<div class="post-right-box"></div>
										</div>
											<div class="post-body">
											<div class="post-header-text">
							 		<a href="">' . $row['Job_Title'] . '</a>
							        <p>' . $row['Description'] . '</p>
								 <br/><br/>';
						echo '<a href="apply.php?id=' . $id . '&s_title=' . $row['Description'] . '" class="btn btn-primary">Place Your Application</a></div>
								</div>
								</div></div><br/> ';
					}

					$sql = "SELECT * FROM `Job_Posts` JOIN `Employer_Details` WHERE `Job_Posts`.`Emp_ID`=`Employer_Details`.`Emp_ID` ORDER BY `Job_Posts`.`Post_Time` DESC";
					$rs_result = mysqli_query($con, $sql);
					$total_records = mysqli_num_rows($rs_result);
					$total_pages = ceil($total_records / $num_rec_per_page);
					echo '<div class="col-lg-8" style="text-align:center; font-size:20px">';

					echo "<a href='user.php?page=1'>" . '|< Prev ' . "</a> "; // Goto 1st page  

					for ($i = 1; $i <= $total_pages; $i++) {
						echo "<a href='user.php?page=" . $i . "'>" . $i . "</a> ";
					};
					echo "<a href='user.php?page=$total_pages'>" . ' Next >|' . "</a> "; // Goto last page
					echo '</div>';
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap Core JavaScript -->
	<script src="components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- Menu Toggle Script -->
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