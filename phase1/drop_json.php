<?php

include_once('connect.php');
header("Content-Type: application/json"); 

$contents = file_get_contents("php://input");
$data = json_decode($contents);

$error = false;

$response['result'] = "true";
if (isset($data->c_id) && isset($data->s_id)) {
	conn_db();

	$c_id = mysqli_real_escape_string($db_link, $data->c_id);
	$s_id = mysqli_real_escape_string($db_link, $data->s_id);
		
	$query = "select * from enrolment where (student_id='$s_id' and course_id='$c_id');";
	$result = mysqli_query($db_link, $query);
	
	if($result && mysqli_num_rows($result) > 0) {
		$query = "delete from enrolment where student_id='$s_id' and course_id='$c_id';";
		$result = mysqli_query($db_link, $query);
		if(!$result) {
			$response['result'] = "false1";
		} else {
			$response['result'] = "true";
		}
	} else {
		$response['result'] = "false2";
	}
	
	close_db();

} else {
	$response['result'] = "false3";
}

echo json_encode($response);

?>