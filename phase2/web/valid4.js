function validateform() {
    var course_id = document.forms["myform"]["course_id"].value;
    var inst_id = document.forms["myform"]["inst_id"].value;
    var course_name = document.forms["myform"]["course_name"].value;
    var course_field = document.forms["myform"]["course_field"].value;

    //check if course_id not empty
    if (course_id == "" || course_id == null) {
        alert("Please enter course id.");
        return false;
    }

    //check if inst_id not empty
    if (inst_id == "" || inst_id == null) {
        alert("Please enter instructor id.");
        return false;
    }

    //check if course_name not empty
    if (course_name == "" || course_name == null) {
        alert("Please enter course name.");
        return false;
    }

    //check if course_field not empty
    if (course_field == "" || course_field == null) {
        alert("Please enter course field.");
        return false;
    }

    // Entering valid id
    if (/\D$/i.test(course_id)) {
        alert("Please enter valid course id ");
        return false;
    }

    // Entering valid id
    if (/\D$/i.test(inst_id)) {
        alert("Please enter valid instructor id ");
        return false;
    }

    return true;
}


function f1() {
    if (validateform())
        document.forms["myform"].submit();
}
