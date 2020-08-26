<?php include "header.php"; ?>
<?php include_once('connect.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
	header('Location:student_sign_in.php');
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['course_id']) && isset($_POST['name']) && isset($_POST['field'])) {
		
		conn_db();

		$instructor_id = $_SESSION['user_id'];
		$course_id = mysqli_real_escape_string($db_link, $_POST['course_id']);
		$name = mysqli_real_escape_string($db_link, $_POST['name']);
		$field = mysqli_real_escape_string($db_link, $_POST['field']);
		$description = mysqli_real_escape_string($db_link, $_POST['description']);
		$book_cover = "";
		
		if (is_uploaded_file($_FILES["book_cover"]["tmp_name"])) {
			$book_cover = addslashes(file_get_contents($_FILES["book_cover"]["tmp_name"]));
			$result = mysqli_query($db_link, "update course set name = '$name', field = '$field', description = '$description', book_cover = '$book_cover' where id = '$course_id';");
		} else {
			$result = mysqli_query($db_link, "update course set name = '$name', field = '$field', description = '$description' where id = '$course_id';");
		}
		
		if(!$result) {
			$_SESSION['error_msg'] = "Error:" . mysqli_error($db_link);
		} else {
			$_SESSION['sucess_msg'] = "The course has been edited successfully.";
		}
		
		close_db();
		
		if($result) {
			header('Location:course.php?id=' . $course_id);
			exit;
		}
	} else {
		$_SESSION['msg'] = "Please fill all required data.";
	}
}
else if (!isset($_REQUEST['id'])) {
	header('Location:index.php');
}
else {
	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];

	if (isset($_REQUEST['mode']))
		$mode = $_REQUEST['mode'];
	
	$id = $_REQUEST['id'];

	conn_db();
	
	$query = "select c.*, i.name as instructor_name from course as c, instructor as i where c.instructor_id=i.id and c.id=$id;";
	$result = mysqli_query($db_link, $query);
	$course = mysqli_fetch_array($result);

	$students = array();
	$result = mysqli_query($db_link, "select s.* from student as s, enrolment as e where s.id=e.student_id and e.course_id=$id;");
	while ($row = mysqli_fetch_assoc($result))
		$students[] = $row;

	close_db();
}


?>

	<div id="page">
	
		<section style="text-align: center;">
			<header class="major">
				<h2>Course Information</h2>
			</header>
		</section>
		
		<?php if (isset($mode) && $mode == 'edit') { ?>
		
		<section>
			<h3>Edit Course</h3>
			<form id="editForm" name="myform" action="edit.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<legend>Enter course information</legend>
					<input type="hidden" id="course_id" name="course_id" value="<?php echo $course['id']; ?>">
					<label for="name" id="name">Course Name:</label>
					<input type="text" id="course_name" name="course_name" value="<?php echo $course['name']; ?>">
					<label for="field" id="field">Course Field:</label>
					<input type="text" id="course_field" name="course_field" value="<?php echo $course['field']; ?>">
					<label for="description" id="description">Course description:</label>
					<textarea id="course_description" name="course_description" rows="6" cols="55" placeholder="description"><?php echo $course['description']; ?></textarea>
					<!--<label for="book_cover" id="book_cover">Course Book Cover:</label>
					<input type="file" id="book_cover" name="course_book_cover" />-->
					<input class="button" id="edit" type="button" value="Save Changes"> <!--onclick="submit()" -->
				</fieldset>
				
				 <?php if(!empty($msg)) echo "<p'>" . $msg . "</p>"; ?>
				 <p id="msg" style="text-align: center; color: red;"> <p>
			</form>
		</section>
		
		<?php } else { ?>
		
		<section>
			<h3>Course Information</h3>
			<?php if(!empty($msg)) echo "<p'>" . $msg . "</p>"; ?>
			<table>
				<tr>
					<th width="10%">ID:</th>
					<td><?php echo $course['id']; ?></td>
				</tr>
				<tr>
					<th>Name:</th>
					<td><?php echo $course['name']; ?></td>
				</tr>
				<tr>
					<th>Field:</th>
					<td><?php echo $course['field']; ?></td>
				</tr>
				<tr>
					<th>Description:</th>
					<td><?php echo $course['description']; ?></td>
				</tr>
				<tr>
					<th>Book Cover:</th>
					<td><?php echo '<img style="width: 30%;" src="data:image/jpeg;base64,' .base64_encode($course['book_cover']) . '"/>'; ?></td>
				</tr>
			</table>
		</section>
		
		<?php
		if ($user_type == 'instructor') {
		?>
		
		<section style="text-align: center;">
			<a href="course.php?mode=edit&id=<?php echo $course['id']; ?>">Edit</a>
		</section>
	
		<section id="enrolled_students">
			<h3>Enrolled students</h3>
			<table>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
				</tr>
				<?php 
					foreach ($students as $student) {
				?>	
				<tr>
					<td><?php echo $student['id']; ?></td>
					<td><?php echo $student['name']; ?></td>
					<td><?php echo $student['email']; ?></td>
				</tr>
				<?php } ?>
			</table>
		</section>
		
		<?php } else { ?>
		<section style="text-align: center;">
			<a href="enroll.php?id=<?php echo $course['id']; ?>">Enroll</a> | <a href="drop.php?id=<?php echo $course['id']; ?>">Drop</a>
		</section>
		<?php } ?>
		<?php } ?>
	</div>

<?php include "footer.php"; ?>