<?php include "header.php"; ?>
<?php include_once('connect.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
	header('Location:student_sign_in.php');
} else if ($_SESSION['user_type'] != 'student') {
	header('Location:index.php');
}
else {
	$user_id = $_SESSION['user_id'];

	conn_db();

	$query = "select * from student where id='$user_id';";
	$result = mysqli_query($db_link, $query);
	$user = mysqli_fetch_array($result);

	$courses1 = array();
	$result = mysqli_query($db_link, "select c.* from course c, enrolment e where c.id=e.course_id and e.student_id='$user_id';");
	while ($row = mysqli_fetch_assoc($result))
		$courses1[] = $row;

	$courses2 = array();
	$result = mysqli_query($db_link, "select * from course where id not in (select course_id from enrolment where student_id='$user_id');");
	while ($row = mysqli_fetch_assoc($result))
		$courses2[] = $row;

	close_db();
}
?>

	<div id="page">
	
		<section style="text-align: center;">
			<header class="major">
				<h2>Student Homepage</h2>
			</header>
		</section>
		
		<section>
			<h3>Student Information</h3>
			
			<table id="std_info">

			</table>
			
			<?php echo "<script> loadStudentInfo($user_id); </script>"; ?>
		</section>
		
		<section>
			<h3>Avaliable Courses</h3>
			<?php if(!empty($msg)) echo "<p'>" . $msg . "</p>"; ?>
			<p id="msg" style="text-align: center; color: red;"> <p>
			<table>
				<tr>
					<th>Course</th>
					<th colspan="2">Status </th>
				</tr>
				<?php 
					foreach ($courses1 as $course) {
				?>	
				<tr>
					<td><a href="course.php?id=<?php echo $course['id']; ?>"><?php echo $course['name']; ?></a></td>
					<td id="enroll_td_<?php echo $course['id']; ?>">Enrolled</td>
					<!--<td id="drop<?php echo $course['id']; ?>"><a href="drop.php?id=<?php echo $course['id']; ?>">Drop</a></td>-->
					<td id="drop_td_<?php echo $course['id']; ?>"><a id="drop_<?php echo $course['id']; ?>" class="drop" href="drop_<?php echo $user_id; ?>" onclick="drop(this);">Drop</a></td>
				</tr>
				<?php } ?>
				<?php 
					foreach ($courses2 as $course) {
				?>	
				<tr>
					<td><a href="course.php?id=<?php echo $course['id']; ?>"><?php echo $course['name']; ?></a></td>
										
					<td id="enroll_td_<?php echo $course['id']; ?>"><a id="enroll_<?php echo $course['id']; ?>" class="enroll" href="enroll_<?php echo $user_id; ?>">Enroll</a></td>
					<td id="drop_td_<?php echo $course['id']; ?>"></td>
				</tr>
				<?php } ?>
			</table>
		</section>
		
	</div>

<?php include "footer.php"; ?>