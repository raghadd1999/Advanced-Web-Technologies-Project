<?php 
    ob_start();
    session_start();
	
	$msg = "";
	
	if(isset($_SESSION['msg'])) {
		$msg = $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>KSU</title>
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="web1.css" />
	<script src="valid.js"></script>
	<script src="valid2.js"></script>
	<script src="valid3.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src='ajax_script.js'></script>
</head>
<body>

	<header id="header">
		<div id="logo">
			<img src ="logo.png" alt ="logo" >
			<h1><a href="index.php">Welcome to KSU</a></h1>
		</div>
		
		<?php  if (isset($_SESSION['user_id'])) { ?>
		<div class="welcome">
			Welcome <?php echo $_SESSION['user_name']; ?> <a href="signout.php">Sign Out</a>
		</div>
		<?php } ?>
		
		<nav id="nav">
			<ul>
				<li><a href="index.php">Homepage</a></li>
				<?php if (isset($_SESSION['user_id'])) { ?>
				<?php if ($_SESSION['user_type'] == 'instructor') { ?><li><a href="instructor.php">Instructor Homepage</a></li> <?php } ?>
				<?php if ($_SESSION['user_type'] == 'student') { ?><li><a href="student.php">Student Homepage</a></li> <?php } ?>
				<?php } else { ?>
				<li><a href="Instructor_Log_in.php">Instructor sign in</a></li>
				<li><a href="student_sign_in.php">Student sign in</a></li>
				<?php } ?>
			</ul>
		</nav>
	</header>
