<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf8"?>';
echo "<students>";

if (!isset($_REQUEST['id'])) {
	echo "</students>";
	exit;
}

include_once('connect.php');

$id = $_REQUEST['id'];

conn_db();

$students = array();
$result = mysqli_query($db_link, "select s.* from student as s, enrolment as e where s.id=e.student_id and e.course_id=$id;");
while ($row = mysqli_fetch_assoc($result))
	$students[] = $row;

foreach ($students as $student) {
	echo "<student>";
	echo "<id>" . $student['id'] . "</id>";
	echo "<name>" . $student['name'] . "</name>";
	echo "<email>" . $student['email'] . "</email>";
	echo "</student>";
}

echo "</students>";
?>