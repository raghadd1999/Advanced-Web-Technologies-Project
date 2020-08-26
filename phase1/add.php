<?php include "header.php"; ?>
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
			$query = "insert into course (id, instructor_id, name, field, description) values ('$id', '$user_id', '$name', '$field', '$description');";
		else
			$query = "insert into course (id, instructor_id, name, field, description, book_cover) values ('$id', '$user_id', '$name', '$field', '$description', '$book_cover');";
		
		$result = mysqli_query($db_link, $query);
		
		if(!$result)
			$_SESSION['msg'] = "Error:" . mysqli_error($db_link);
		else
			$_SESSION['msg'] = "The course added successfully.";

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

	<div id="page">
	
		<section style="text-align: center;">
			<header class="major">
				<h2>Add Course</h2>
			</header>
		</section>

		<section>
			<form name="myform" action="add.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<legend>Enter course information</legend>
					<label for="id" id="id">Course ID*:</label>
					<input type="text" id="id" name="course_id">
					<label for="name" id="name">Course Name*:</label>
					<input type="text" id="name" name="course_name">
					<label for="field" id="field">Course Field*:</label>
					<input type="text" id="field" name="course_field">
					<label for="description" id="description">Course description:</label>
					<textarea id="description" name="course_description" rows="6" cols="55" placeholder="description"></textarea>
					<label for="book_cover" id="book_cover">Course Book Cover:</label>
					<input type="file" id="book_cover" name="course_book_cover" />
					<input class="button" id="log" type="button" onclick="submit()" value="Add">
				</fieldset>
				
				 <?php if(!empty($msg)) echo "<p'>" . $msg . "</p>"; ?>
			</form>
		</section>
		
	</div>

<?php include "footer.php"; ?>