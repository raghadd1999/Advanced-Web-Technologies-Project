<?php session_start(); ?>
<?php include_once('connect.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
	header('Location:Instructor_Log_in.php');
} else if ($_SESSION['user_type'] != 'instructor') {
	header('Location:index.php');
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['course_id']) && !empty($_POST['course_id']) && isset($_POST['course_name']) && !empty($_POST['course_name']) && isset($_POST['course_field']) && !empty($_POST['course_field'])) {
		
		conn_db();

		$user_id = $_SESSION['user_id'];
		$id = mysqli_real_escape_string($db_link, $_POST['course_id']);
		$name = mysqli_real_escape_string($db_link, $_POST['course_name']);
		$field = mysqli_real_escape_string($db_link, $_POST['course_field']);
		$description = mysqli_real_escape_string($db_link, $_POST['course_description']);
		$book_cover = "";
		
		if (is_uploaded_file($_FILES["course_book_cover"]["tmp_name"]))
			$book_cover = addslashes(file_get_contents($_FILES["course_book_cover"]["tmp_name"]));
		
		if (empty($book_cover))
			$query = "update course set name = '$name', field = '$field', description = '$description' where id = '$id';";
		else
			$query = "update course set name = '$name', field = '$field', description = '$description', book_cover = '$book_cover' where id = '$id';";

		$result = mysqli_query($db_link, $query);
		
		if(!$result)
			$_SESSION['msg'] = "Error:" . mysqli_error($db_link);
		else
			$_SESSION['msg'] = "The course edited successfully.";

		close_db();
		
		if($result) {
			$course_id = mysqli_insert_id ($conn);
			header('Location:course.php?id=' . $id);
			exit;
		}
	} else {
		$_SESSION['msg'] = "Please fill all required data.";
	}
	header('Location:' . $_SERVER['HTTP_REFERER']);
}
?>