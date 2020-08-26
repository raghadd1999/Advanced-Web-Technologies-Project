<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf8"?>';
echo "<students>";

include_once('connect.php');

conn_db();

$students = array();
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$result = mysqli_query($db_link, "select * from student where id=$id;");
}
else
	$result = mysqli_query($db_link, "select * from student;");

while ($row = mysqli_fetch_assoc($result))
	$students[] = $row;

foreach ($students as $student) {
	echo "<student>";
	echo "<id>" . $student['id'] . "</id>";
	echo "<name>" . $student['name'] . "</name>";
	echo "<username>" . $student['name'] . "</username>";
	echo "<email>" . $student['email'] . "</email>";
	echo "</student>";
}

echo "</students>";
?>