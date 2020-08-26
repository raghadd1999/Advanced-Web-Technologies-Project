<?php include "header.php"; ?>
<?php include_once('connect.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
	header('Location:student_sign_in.php');
} else if ($_SESSION['user_type'] != 'instructor') {
	header('Location:index.php');
}
else {
	$user_id = $_SESSION['user_id'];

	conn_db();

	$query = "select * from instructor where id='$user_id';";
	$result = mysqli_query($db_link, $query);
	$user = mysqli_fetch_array($result);

	$courses = array();
	$result = mysqli_query($db_link, "select * from course where instructor_id='$user_id';");
	while ($row = mysqli_fetch_assoc($result))
		$courses[] = $row;

	close_db();
}
?>

	<div id="page">
	
		<section style="text-align: center;">
			<header class="major">
				<h2>Instructor Homepage</h2>
			</header>
		</section>
		
		<section>
			<h3>Instructor Information</h3>
			<table>
				<tr>
					<th width="10%">ID:</th>
					<td><?php echo $user['id']; ?></td>
				</tr>
				<tr>
					<th>Username:</th>
					<td><?php echo $user['username']; ?></td>
				</tr>
				<tr>
					<th>Full Name:</th>
					<td><?php echo $user['name']; ?></td>
				</tr>
				<tr>
					<th>Email:</th>
					<td><?php echo $user['email']; ?></td>
				</tr>
				<tr>
					<th>Speciality:</th>
					<td><?php echo $user['speciality']; ?></td>
				</tr>
			</table>
		</section>
		
		<section>
			<h3>Avaliable Courses</h3>
			<a href="add.php"> + Add Course</a>
			<table>
				<tr>
					<th colspan="3">Course </th>
				</tr>
				<?php 
					foreach ($courses as $course) {
				?>
				<tr>
					<td><a href="course.php?id=<?php echo $course['id']; ?>"><?php echo $course['name']; ?></a></td>
					
					<td>
						<a class="collaps" href="" id="link_<?php echo $course['id']; ?>" >Display students list</a>
						
						<table class="slist" style="display: none;">
						<tbody id="slist<?php echo $course['id']; ?>">
						</tbody>
						</table>
					</td>
					
					<td><a href="course.php?mode=edit&id=<?php echo $course['id']; ?>">Edit</a></td>
				</tr>
				<?php } ?>
			</table>
		</section>
		
	</div>

<?php include "footer.php"; ?>