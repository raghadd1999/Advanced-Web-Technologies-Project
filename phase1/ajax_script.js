
$(document).ready(function() {

	$('.collaps').click(function(e) {
		e.preventDefault(); 
		$(this).removeAttr('href');
		$(this).next().toggle();
		var id = $(this).attr("id").substring(5);
		loadStudents(id);
		$(this).attr("href", "#");
	});
	
	$('.std_inro').click(function(e) {
		e.preventDefault(); 
		$(this).removeAttr('href');
		$(this).next().toggle();
		var id = $(this).attr("id").substring(5);
		loadStudents(id);
		$(this).attr("href", "#");
	});
	
	$('.enroll').click(function(e) {
		e.preventDefault();
		var c_id = $(this).attr("id").substring(7);
		var s_id = $(this).attr("href").substring(7);
		$(this).removeAttr('href');
		enrollCourse(c_id, s_id);
		$(this).attr("href", "#");
	});
	
	$('.drop').click(function(e) {
		e.preventDefault();
		var c_id = $(this).attr("id").substring(5);
		var s_id = $(this).attr("href").substring(5);
		$(this).removeAttr('href');
		dropCourse(c_id, s_id);
		$(this).attr("href", "#");
	});
	
	$('input#edit').click(function(e) {
		e.preventDefault();
		$(this).attr("disabled", "disabled");
		editCourse();
	});
});

function drop(e) {
	//$(e).preventDefault();
	var c_id = $(e).attr("id").substring(5);
	var s_id = $(e).attr("href").substring(5);
	$(e).removeAttr('href');
	dropCourse(c_id, s_id);
	$(e).attr("href", "#");
}

function enroll(e) {
	//$(e).preventDefault();
	var c_id = $(e).attr("id").substring(7);
	var s_id = $(e).attr("href").substring(7);
	$(e).removeAttr('href');
	enrollCourse(c_id, s_id);
	$(e).attr("href", "#");
}

function loadStudents(id) {
	
	$.ajax({
		type: "GET",
		dataType: "xml",
		url: "std_list.php?id=" + id,
		cache: false,
		success: function(xmldata) {
			var str = '';
			$(xmldata).find('student').each(function() {
				str += '<tr><td>' + $(this).find('id').text() + '</td><td>' + $(this).find('name').text() + '</td><td>' + $(this).find('email').text() +  '</td></tr>';
			});
			
			if (str != '')
				$('#slist' + id).html(str);
			else
				$('#slist' + id).html('Empty');
		}
	});
}

function loadStudentInfo(id) {
	
	$.ajax({
		type: "GET",
		dataType: "xml",
		url: "std_info.php?id=" + id,
		cache: false,
		success: function(xmldata) {
			var str = '';
			$(xmldata).find('student').each(function() {
				str += '<tr><th width="10%">ID:</th><td>' + $(this).find('id').text() + '</td></tr><tr><th>Username:</th><td>' + $(this).find('username').text() + '</td></tr><tr><th>Full Name:</th><td>' + $(this).find('email').text() +  '</td></tr>' + '</td></tr><tr><th>Email:</th><td>' + $(this).find('email').text() +  '</td></tr>';
			});
			

			
			
			if (str != '')
				$('#std_info').html(str);
			else
				$('#std_info').html('');
		}
	});
}

function editCourse() {
	var form = $(this);
	var course_id = $("input#course_id");
	var course_name = $("input#course_name");
	var course_field = $("input#course_field");
	var course_description = $("textarea#course_description");
	var msg = $("#msg");
	
	var send_data = JSON.stringify({"mode": "edit", "course_id": course_id.val(), "name": course_name.val(), "field": course_field.val(), "description": course_description.val()});

	$.ajax({
		url: "course_json.php",
		type:"POST",
		dataType: "json",
		contentType: "application/json",
		data: send_data,
		success: function(response){
			if (response.result == "false") {
				msg.text("An Error Happened");
			} else {
				course_name.attr("disabled", "disabled");
				course_field.attr("disabled", "disabled");
				course_description.attr("disabled", "disabled");
				msg.css("color", "green");
				msg.text("Updated Successfully");
			}
		},
		error: function(data) {
			msg.text("An Error Happened");
			console.log(data);
		}
	});
}

function enrollCourse(c_id, s_id) {
	var msg = $("#msg");
	var enroll = $('#enroll' + c_id);
	var drop = $('#drop' + c_id);
	
	msg.text("");
	msg.css("color", "red");
	
	var send_data = JSON.stringify({"c_id": c_id, "s_id": s_id});

	$.ajax({
		url: "enroll_json.php",
		type:"POST",
		dataType: "json",
		contentType: "application/json",
		data: send_data,
		success: function(response){
			if (response.result == "false") {
				msg.text("An Error Happened");
			} else {
				msg.css("color", "green");
				msg.text("You have been enrolled to the course successfully.");
				
				var str = '<a id="drop_"' + c_id + '" class="drop" href="drop_' + s_id + '" >Drop' + '</a>';
				 str = '<a id="drop_"' + c_id + '" class="drop" onclick="drop(this)" >Drop' + '</a>';
				str = '<a id="drop_' + c_id + '" class="drop" href="drop_' + s_id + '" onclick="drop(this)" >Drop' + '</a>';
				
				$('#enroll_' + c_id).text("");
				$('#drop_td_' + c_id).html(str);
				$('#enroll_td_' + c_id).html("Enrolled");
				
			}
		},
		error: function(data) {
			msg.text("An Error Happened");
			console.log(data);
		}
	});
}

function dropCourse(c_id, s_id) {
	var msg = $("#msg");
	var enroll = $('#enroll' + c_id);
	var drop = $('#drop' + c_id);
	msg.text("");
	msg.css("color", "red");
	
	var send_data = JSON.stringify({"c_id": c_id, "s_id": s_id});

	$.ajax({
		url: "drop_json.php",
		type:"POST",
		dataType: "json",
		contentType: "application/json",
		data: send_data,
		success: function(response){
			if (response.result == "false") {
				msg.text("An Error Happened");
			} else {
				msg.css("color", "green");
				msg.text("You have been droped the course successfully.");
				
				var str = '<a id="enroll_"' + $.trim(c_id) + '" class="enroll" href="enroll_' + s_id + '" >Enroll' + '</a>';
				str = '<a id="enroll_' + c_id + '" class="enroll" href="enroll_' + s_id + '" onclick="enroll(this)" >Enroll' + '</a>';
				
				$('#drop_' + c_id).text("");
				$('#enroll_td_' + c_id).html(str);
				
			}
		},
		error: function(data) {
			msg.text("An Error Happened");
			console.log(data);
		}
	});
}
