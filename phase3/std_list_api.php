<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf8"?>';
include_once('connect.php');
conn_db();

echo "<list>";

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];

	$students = array();
	$result = mysqli_query($db_link, "select s.* from student as s, enrolment as e where s.id=e.student_id and e.course_id=$id;");
	while ($row = mysqli_fetch_assoc($result))
		$students[] = $row;
	echo "<course id=\"$id\">";
	foreach ($students as $student) {
		echo "<student>";
		echo "<id>" . $student['id'] . "</id>";
		echo "<name>" . $student['name'] . "</name>";
		echo "<email>" . $student['email'] . "</email>";
		echo "</student>";
	}	
	echo "</course>";
} else {
	$course_list = mysqli_query($db_link, "select course_id from enrolment group by course_id;");
	while ($c = mysqli_fetch_assoc($course_list)) {
		$id = $c['course_id'];

		$students = array();
		$result = mysqli_query($db_link, "select s.* from student as s, enrolment as e where s.id=e.student_id and e.course_id=$id;");
		while ($row = mysqli_fetch_assoc($result))
			$students[] = $row;
		echo "<course id=\"$id\">";
		foreach ($students as $student) {
			echo "<student>";
			echo "<id>" . $student['id'] . "</id>";
			echo "<name>" . $student['name'] . "</name>";
			echo "<email>" . $student['email'] . "</email>";
			echo "</student>";
		}	
		echo "</course>";
	}
}

echo "</list>";
?>