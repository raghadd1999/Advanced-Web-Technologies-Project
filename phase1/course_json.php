<?php

include_once('connect.php');
header("Content-Type: application/json"); 

$contents = file_get_contents("php://input");
$data = json_decode($contents);

$error = false;

$response['result'] = "true";
if (isset($data->mode) && isset($data->name) && isset($data->field)) {
	if ($data->mode == 'add') {
	} else if ($data->mode == 'edit' && isset($data->course_id)) {
		
		conn_db();

		$course_id = mysqli_real_escape_string($db_link, $data->course_id);
		$name = mysqli_real_escape_string($db_link, $data->name);
		$field = mysqli_real_escape_string($db_link, $data->field);
		$description = mysqli_real_escape_string($db_link, $data->description);
		
		if (!empty($course_id) && !empty($name) && !empty($field) && !empty($description)) {
			$result = mysqli_query($db_link, "update course set name = '$name', field = '$field', description = '$description' where id = '$course_id';");
		}
		
		if(!$result) {
			$response['result'] = "false";
		} else {
			$response['result'] = "true";
		}
		
		close_db();

	} else {
		$response['result'] = "false";
	}
}

echo json_encode($response);

?>