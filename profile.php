<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'chimerasite_cms';
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $conn->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<?php
		include 'head.php';
	?>
	<body class="loggedin">
		<!-- navbar -->
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<div class="container-fluid">
				<a class="navbar-brand" href="#"><img src="css/images/logo_white.png" alt="Logo" style="width:25px; margin-top:-5px;"> Stargazer</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<li class="nav-item">
						<a class="nav-link" href="dashboard.php">Dashboard</a>
						</li>
						<li class="nav-item">
						<a class="nav-link" href="manage.php">Manage</a>
						</li>
						<li class="nav-item">
						<a class="nav-link active" href="profile.php">Profile</a>
						</li>
						<li class="nav-item">
						<a class="nav-link" href="help.php">Help</a>
						</li>
					</ul>
				</div>
				<a href="logout.php" style="width:112.78px; text-align:right;"><i class="fas fa-sign-out-alt"></i></a>				
			</div>
		</nav>

		<!-- main content -->
		<div class="content">
			<h2>Profile</h2>
			<div>
				<div class="column_form">
					<form id="help-form" data-parsley-validate="" class="form container" action="" method="post">
						<div class="row">
							<div class="col-3">
								<label>Username</label>
							</div>
							<div class="col-9">
								<input type="text" class="form-colums" value="<?=$_SESSION['name']?>">
							</div>
						</div>
						<div class="row">
							<div class="col-3">
								<label>Email</label>
							</div>
							<div class="col-9">
								<input type="text" class="form-colums" value="<?=$email?>">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-3">
								<label for="Current_pass">Current Password</label>
							</div>
							<div class="col-9">
								<input type="password" class="form-colums" name="filter" required="">
							</div>
						</div>
						<div class="row">
							<div class="col-3">
								<label for="New_pass">New Password</label>
							</div>
							<div class="col-9">
								<input type="password" class="form-colums" name="New_pass" required="">
							</div>
						</div>
						<div class="row">
							<div class="col-3">
								<label for="Repeat_pass">Repeat Password</label>
							</div>
							<div class="col-9">
								<input type="password" class="form-colums" name="Repeat_pass" required="">
							</div>
						</div>
						<input type="submit" class="submit-btn" value="Change Password" name="changePass">
					</form>
				</div>
			</div>
		</div>
		<div class="pageDoll d-flex">
			<img src="css/images/pageDoll.png" class="pageDoll">
		</div>
	</body>
	<footer class="footer container-fluid">
		<div class="f-content">
			<div>
				&copy; 2022 Cheyenne. All Rights Reserved
			</div>
			<div style="width: 25%;" class="d-flex justify-content-around">
				<div>
					Donate 
				</div>
				<div>
					Privacy Policy 
				</div>
				<div>
					Terms of Service 
				</div>
			</div> 
		</div>
	</footer>
</html>