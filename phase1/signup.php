<?php include "header.php"; ?>
<?php include_once('connect.php'); ?>

<?php
if (isset($_SESSION['user_id'])) {
	if ($_SESSION['user_type'] == 'student')
		header('Location:student.php');
	else if ($_SESSION['user_type'] == 'instructor')
		header('Location:instructor.php');
	else 
		header('Location:index.php');
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['user_id']) && isset($_POST['user_fullname']) && isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_password'])) {
		conn_db();

		$email = mysqli_real_escape_string($db_link, $_POST['user_email']);
		$name = mysqli_real_escape_string($db_link, $_POST['user_name']);
				
		$query = "select * from student where email='$email' or username='$name'";
		$result = mysqli_query($db_link, $query);
		
		close_db();

		if($result && mysqli_num_rows($result) > 0){
			$_SESSION['msg'] = "Email or username already exists.";
		} else {
			conn_db();
			
			$id = mysqli_real_escape_string($db_link, $_POST['user_id']);
			$fullname = mysqli_real_escape_string($db_link, $_POST['user_fullname']);
			$pwd = mysqli_real_escape_string($db_link, $_POST['user_password']);
			$pwd = md5($pwd);
			
			$result = mysqli_query($db_link, "insert into student (id, username, password, name, email) values ('$id', '$name', '$pwd', '$fullname', '$email');");
				
			close_db();

			if($result){
				$_SESSION['user_id'] = $id;
				$_SESSION['user_name'] = $name;
				$_SESSION['user_type'] = 'student';

				header('Location:student.php');
				exit;
			} else {
				$_SESSION['msg'] = "Error in sign-up." . mysqli_error($db_link);
			}
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
				<h2>Student Sign-Up</h2>
			</header>
		</section>
		
		<form name="myform" action="signup.php" method="POST">
			<fieldset>
				<legend>Enter your information</legend>
				<label for="id" id="id">ID:</label>
				<input type="text" id="id" name="user_id">
				<label for="fullname" id="fullname">Full Name:</label>
				<input type="text" id="fullname" name="user_fullname">
				<label for="name" id="name">Username:</label>
				<input type="text"  id="name" name="user_name">
				<label for="mail">Email:</label>
				<input type="email" id="mail" name="user_email">
				<label for="password">Password:</label>
				<input type="password" id="password" name="user_password">
				<input class="button" id="log" type="button" onclick="f1()" value="sign-up">
			</fieldset>
			
			 <?php if(!empty($msg)) echo "<p'>" . $msg . "</p>"; ?>
		</form>
	</div>

<?php include "footer.php"; ?>