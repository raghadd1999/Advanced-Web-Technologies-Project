<?php session_start(); ?>
<?php include_once('connect.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
	header('Location:student_sign_in.php');
} else if ($_SESSION['user_type'] != 'student') {
	header('Location:index.php');
} else if (isset($_REQUEST['id'])) {
	conn_db();

	$user_id = $_SESSION['user_id'];
	$id = mysqli_real_escape_string($db_link, $_REQUEST['id']);
	
	$query = "select * from enrolment where (student_id='$user_id' and course_id='$id');";
	$result = mysqli_query($db_link, $query);
	
	if($result && mysqli_num_rows($result) > 0) {
		$_SESSION['msg'] = "You have been enrolled to this course before.";
	} else {
		$query = "insert into enrolment (student_id, course_id) values ('$user_id', '$id');";
		$result = mysqli_query($db_link, $query);
		$_SESSION['msg'] = "You have been enrolled to the course successfully.";
	}

	close_db($conn);
	
	header('Location:' . $_SERVER['HTTP_REFERER']);
}
?>