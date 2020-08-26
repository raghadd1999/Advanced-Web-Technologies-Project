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
	if (isset($_POST['user_email']) && isset($_POST['user_password'])) {
		conn_db();

		$email = mysqli_real_escape_string($db_link, $_POST['user_email']);
		$pwd = mysqli_real_escape_string($db_link, $_POST['user_password']);
		$pwd = md5($pwd);
		
		$query = "select * from student where email='$email' and password='$pwd'; ";
		$result = mysqli_query($db_link, $query);
		
		close_db();

		if($result && mysqli_num_rows($result) > 0){
			$user = mysqli_fetch_array($result);
			
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['user_name'] = $user['username'];
			$_SESSION['user_type'] = 'student';

			header('Location:student.php');
			exit;
		} else {
			$_SESSION['msg'] = "Email or password is not correct.";
		}
	} else {
		$_SESSION['msg'] = "Please fill all required data.";
	}
}
?>

	<div id="page">
		<section style="text-align: center;">
			<header class="major">
				<h2>Student Log-in</h2>
			</header>
		</section>
		
		<form name="myform" action="student_sign_in.php" method="POST">
			<fieldset>
				 <label for="mail">Email:</label>
				 <input type="email" id="mail" name="user_email" value="aaaa@aaaa.com">
				 <label for="password">Password:</label>
				 <input type="password" id="password" name="user_password" value="aaaa.aaaa.com">
				 <input class="button" id="log" type="button" onclick="f2()" value="sign-in">
			 </fieldset>
			 
			 <?php if(!empty($msg)) echo "<p'>" . $msg . "</p>"; ?>
		</form>
	</div>

<?php include "footer.php"; ?>
