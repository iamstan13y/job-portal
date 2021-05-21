<?php
require 'connect_db.php';
?>

<?php
function timeAgo($time_ago)
{
	$time_ago = strtotime($time_ago);
	$cur_time = (time() + 3600);
	$time_elapsed = $cur_time - $time_ago;
	$seconds = $time_elapsed;
	$minutes = round($time_elapsed / 60);
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
	else
	 if ($minutes <= 60) {
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

//Employer Login
if (isset($_POST["btn-login"])) {
	$email = $_POST["txt_uname_email"];
	$pass = $_POST["txt_password"];

	$sql = mysqli_query($con, "SELECT * FROM `Employer_Details` WHERE `Email`='$email' AND Password='$pass'");
	if (mysqli_num_rows($sql)) {
		while ($row = mysqli_fetch_array($sql)) {
			$name = $row["Name"];
			$id = $row["Emp_ID"];
			session_start();
			$_SESSION["name"] = $name;
			$_SESSION["id"] = $id;
			$_SESSION["email"] = $email;
		}
		header("location:employer.php");
	} else {
		echo '<script>alert("Wrong Username Or Password!");</script>';
	}
}

//Job seeker login
if (isset($_POST["btn-userlogin"])) {
	$email = $_POST["txt_uname_email"];
	$pass = $_POST["txt_password"];

	$sql = mysqli_query($con, "SELECT * FROM `Job_Seekers` WHERE `Email`='$email' AND Password='$pass'");
	if (mysqli_num_rows($sql)) {
		while ($row = mysqli_fetch_array($sql)) {
			$name = $row["Firstname"] . " " . $row["Lastname"];
			$id = $row["User_ID"];
			session_start();
			$_SESSION["name"] = $name;
			$_SESSION["id"] = $id;
			$_SESSION["email"] = $email;
		}
		header("location:user.php");
	} else {
		echo '<script>alert("Wrong Username Or Password!");</script>';
	}
}

?>

<?php
if (isset($_POST['btn-usersignup'])) {
	$fname = strip_tags($_POST['txt_fname']);
	$lname = strip_tags($_POST['txt_lname']);
	$email = strip_tags($_POST['txt_email']);
	$phone = strip_tags($_POST['txt_phone']);
	$skills = strip_tags($_POST['txt_skills']);
	$qualifications = strip_tags($_POST['txt_quals']);
	$password = strip_tags($_POST['txt_password']);
	$pic = $_FILES["img"]["name"];
	$tmp = $_FILES["img"]["tmp_name"];
	$type = $_FILES["img"]["type"];


	$path = "profile_images/" . $pic;
	$icon = "warning";
	$class = "danger";

	if ($fname == "") {
		$error[] = "Provide Name!";
	} else if ($type == "application/pdf" || $type == "application/pdf" || $type == "application/x-zip-compressed") {
		$error[] = "this file type is not supported!";
		echo '<script>alert("this file type is not supported!");</script>';
	} else if ($pic == "") {
		$error[] = "Select Image!";
	} else if ($email == "") {
		$error[] = "Provide Email Address!";
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error[] = 'Please Enter a Valid Email Address !';
	} else if ($password == "") {
		$error[] = "Provide Password!";
	} else {
		$sql = mysqli_query($con, "INSERT INTO `Job_Seekers`(`Firstname`,`Lastname`,`Image`,`Email`,`Password`,`Phone_Number`,`Skills`,`Qualifications`) 
								VALUES('$fname','$lname','$pic','$email','$password','$phone','$skills','$qualifications')");

		if ($sql) {
			move_uploaded_file($tmp, $path);
			echo '<script>alert("Registration Successful!");</script>';
			$icon = "success";
			$class = "success";
		}
	}
}

if (isset($_POST['btn-empsignup'])) {
	$school = strip_tags($_POST['txt_school']);
	$address = strip_tags($_POST['txt_address']);
	$phone = strip_tags($_POST['txt_phone']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);
	$pic = $_FILES["img"]["name"];
	$tmp = $_FILES["img"]["tmp_name"];
	$type = $_FILES["img"]["type"];

	$path = "profile_images/" . $pic;
	$icon = "warning";
	$class = "danger";

	if ($school == "") {
		$error[] = "Provide school name!";
	} else if ($type == "application/pdf" || $type == "application/pdf" || $type == "application/x-zip-compressed") {
		$error[] = "Sorry, this type of file is not supported!";
		echo '<script>alert("Sorry, this type of file is not supported!");</script>';
	} else if ($address == "") {
		$error[] = "Provide your address!";
	} else if ($phone == "") {
		$error[] = "Provide your phone number";
	} else if ($pic == "") {
		$error[] = "Select Image!";
	} else if ($umail == "") {
		$error[] = "Provide email address!";
	} else if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
		$error[] = 'Please enter a valid email address !';
	} else if ($upass == "") {
		$error[] = "Provide password!";
	} else {
		$sql = mysqli_query($con, "INSERT INTO `Employer_Details` (`Name`, `Address`, `Phone_Number`, `Logo`, `Email`, `Password`) VALUES('$school','$address','$phone','$pic', '$umail', '$upass')");
		if ($sql) {
			move_uploaded_file($tmp, $path);
			echo '<script>alert("Registration Successful");</script>';
			$icon = "success";
			$class = "success";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Job Portal | Home</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/colors/green.css" id="colors">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css" id="colors">
</head>

<body>
	<div id="wrapper">
		<header class="transparent sticky-header full-width">
			<div class="container">
				<div class="sixteen columns">
					<div id="logo" style="margin-top:15px">
						<h1><a href="index.php">
								<font style="font-size:25px; color:white">Job Portal</font>
							</a></h1>
					</div>

					<nav id="navigation" class="menu">
						<ul id="responsive">
							<li><a data-toggle="modal" data-target="#empModal" id="current">Post Job</a>
							</li>
						</ul>
						<ul class="float-right">
							<li><a data-toggle="modal" data-target="#userSignupModal"><i class="fa fa-user"></i> Sign Up</a></li>
							<li><a data-toggle="modal" data-target="#userModal"><i class="fa fa-lock"></i> Log In</a></li>
						</ul>
					</nav>

					<!-- Navigation -->
					<div id="mobile-navigation">
						<a href="#menu" class="menu-trigger"><i class="fa fa-reorder"></i> Menu</a>
					</div>

				</div>
			</div>
		</header>
		<div class="clearfix"></div>
		<div id="banner" class="with-transparent-header parallax background" style="background-image: url(images/jfront.jpg)">
			<div class="container">
				<div class="sixteen columns">
					<div class="search-container">
						<div class="announce">
							FINDING YOUR CAREER <strong>CHANGING</strong> YOUR LIFE!
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal for Employer login -->
		<div class="modal fade" id="empModal" tabindex="-1" role="dialog" aria-labelledby="empModalLabel" aria-hidden="true">

			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="empModalLabel">
							Employer Login
						</h4>
					</div>
					<form class="form-signin" method="post" id="login-form">

						<div class="modal-body">
							<input type="email" name="txt_uname_email" placeholder="Email Address" />
						</div>
						<div class="modal-body">
							<input type="password" name="txt_password" placeholder="Password" />
						</div>

						<div class="modal-footer">
							<label align="left">Don't have an account? <a data-dismiss="modal" data-toggle="modal" data-target="#empSignupModal" class="btn btn-default">Sign Up Here</a></label>
							<input type="submit" class="btn btn-primary" name="btn-login" value="Log In">

							</input>
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Close
							</button>

					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for Job Seeker login -->
	<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">

		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>

					<h4 class="modal-title" id="userModalLabel">
						Job Seeker Login
					</h4>
				</div>
				<form class="form-signin" method="post" id="login-form">

					<div class="modal-body">
						<input type="email" name="txt_uname_email" placeholder="Email Address" />
					</div>
					<div class="modal-body">
						<input type="password" name="txt_password" placeholder="Password" />
					</div>

					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" name="btn-userlogin" value="Log In">
						</input>
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
				</form>
			</div>

		</div>
	</div>
	</div>

	<!-- Modal for job seeker sign up -->
	<div class="modal fade" id="userSignupModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>

					<h4 class="modal-title" id="userModalLabel">
						Are you looking for a job? Fill details here!
					</h4>
					<form method="post" class="form-signin" enctype="multipart/form-data">
				</div>
				<div class="modal-body">
					Firstname: <input type="text" name="txt_fname" placeholder="Enter Firstname" required />
				</div>

				<div class="modal-body">
					Lastname: <input type="text" name="txt_lname" placeholder="Enter Lastname" required />
				</div>

				<div class="modal-body">
					Email : <input type="email" name="txt_email" placeholder="Enter Email" required />
				</div>

				<div class="modal-body">
					Phone Number: <input type="text" name="txt_phone" placeholder="Enter Phone Number" required />
				</div>

				<div class="modal-body">
					Skills: <input type="text" name="txt_skills" placeholder="Enter Skills" required />
				</div>

				<div class="modal-body">
					Qualifications: <textarea name="txt_quals" class="form-control" placeholder="e.g. BTech In Computer Science, 2012"></textarea>
				</div>

				<div class="modal-body">
					Password: <input type="password" name="txt_password" placeholder="Enter Skills" required />
				</div>

				<div class="modal-body">
					Upload Profile Photo: <input type="file" name="img" required />
				</div>

				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="SIGN UP" name="btn-usersignup">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
				</div>
				</form>
			</div>
		</div>

	</div>

	<!-- modal for employer sign up -->
	<div class="modal fade" id="empSignupModal" tabindex="-1" role="dialog" aria-labelledby="empSignupModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>

					<h4 class="modal-title" id="empSignupModalLabel">
						Enter Your Institution's Details
					</h4>
					<form method="post" class="form-signin" enctype="multipart/form-data">
				</div>
				<div class="modal-body">
					School / Institution: <input type="text" name="txt_school" placeholder="Institution" required />
				</div>

				<div class="modal-body">
					Address: <input type="text" name="txt_address" placeholder="Enter Address" required />
				</div>

				<div class="modal-body">
					Phone Number: <input type="text" name="txt_phone" placeholder="Enter Phone Number" required />
				</div>

				<div class="modal-body">
					Email : <input type="email" name="txt_umail" placeholder="Enter Email" required />
				</div>
				<div class="modal-body">
					Password: <input type="password" name="txt_upass" placeholder="Enter Password" required />
				</div>
				<div class="modal-body">
					Upload Logo / Profile Photo: <input type="file" name="img" required />
				</div>

				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="SIGN UP" name="btn-empsignup">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
					</input>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="container">
		<!-- Recent Jobs -->
		<h1 class="text-center">Newly Posted Jobs</h1>
		<div class="eleven columns">
			<div class="padding-right">
				<ul class="job-list full">
					<?php
					$sql = mysqli_query($con, "SELECT * FROM `Job_Posts` JOIN `Employer_Details` WHERE `Job_Posts`.`Emp_ID`=`Employer_Details`.`Emp_ID` ORDER BY `Job_Posts`.`Post_Time` DESC");
					while ($row = mysqli_fetch_array($sql)) {
						$job_title = $row["Job_Title"];
						$job_desc = $row["Description"];
						$img = $row["Logo"];
						$emp_name = $row["Name"];
						$time_ago = $row["Post_Time"];
						echo '<li><a href="#">';
						echo '<img src="profile_images/' . $img . '" alt="">';
						echo '<div class="job-list-content">';
						echo '<h3>' . $job_title . '</h3>';
						echo '<p>' . $job_desc . '</p>';
						echo '</div>';
						echo '<div class="job-icons" style="margin-left:100px">';
						echo '<span><i class=""></i><h5><strong>Posted By</strong>: ' . $emp_name . '</h5></span>';
						echo '<span><i class=""></i> </span><br>';
						echo '<span><i class=""></i><font style="color:blue">' . timeAgo($time_ago) . '</font></span>';
						echo '</div>';
						echo '</a>';
						echo '<a data-toggle = "modal" data-target = "#empModal" class="btn btn-default" font style="color:red">APPLY NOW!</a>';
						echo '<br/><br/>';
						echo '</li>';
					}
					?>

				</ul>
			</div>
		</div>

		<div class="five columns">
			<div class="widget">
				<img src="images/post_a_job.jpg" height="100px" width="100px" />
			</div>

			<div class="widget">
				<h2>Find Jobs & Post Jobs</h2>

				<ul class="checkboxes">
					<li>
						<img src="images/fb-jobs.png" height="100px" width="100px" />
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="margin-top-10"></div>

	<div id="footer">
		<div class="container">
			<div class="footer-bottom">
				<div class="sixteen columns">
					<ul class="social-icons">
						<li><a class="facebook" href="https://fb.com/stantontech/"><i class="icon-facebook"></i></a></li>
						<li><a class="twitter" href="https://twitter.com/stanton_zw/"><i class="icon-twitter"></i></a></li>
						<li><a class="gplus" href="https://g.page/stanton_zw?gm/"><i class="icon-gplus"></i></a></li>
						<li><a class="linkedin" href="https://linkedin.com/company/stantondigital/"><i class="icon-linkedin"></i></a></li>
					</ul>
				</div>
			</div>
		</div>

	</div>

	<!-- Back To Top Button -->
	<div id="backtotop"><a href="#"></a></div>

	</div>

	<script src="scripts/jquery-2.1.3.min.js"></script>
	<script src="scripts/custom.js"></script>
	<script src="scripts/jquery.superfish.js"></script>
	<script src="scripts/jquery.themepunch.tools.min.js"></script>
	<script src="scripts/jquery.themepunch.revolution.min.js"></script>
	<script src="scripts/jquery.themepunch.showbizpro.min.js"></script>
	<script src="scripts/jquery.flexslider-min.js"></script>
	<script src="scripts/chosen.jquery.min.js"></script>
	<script src="scripts/jquery.magnific-popup.min.js"></script>
	<script src="scripts/waypoints.min.js"></script>
	<script src="scripts/jquery.counterup.min.js"></script>
	<script src="scripts/jquery.jpanelmenu.js"></script>
	<script src="scripts/stacktable.js"></script>
	<script src="scripts/headroom.min.js"></script>
	<script src="bootstrap/jquery-3.2.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	</div>
</body>

</html>