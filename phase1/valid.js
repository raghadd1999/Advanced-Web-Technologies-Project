function validateform(){
var name=document.forms["myform"]["name"].value;
var password=document.forms["myform"]["user_password"].value;
var email=document.forms["myform"]["user_email"].value;

//check if name not empty
if (name==""|| name== null){
alert("Please enter your name.");
return false;
}
//checking if email is not empty
if (email == ""||email== null){
  alert("Please enter your Email");
  return false;
}
// Entering valid email
 if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
   alert("Please enter valid email ");
   return false;
 }
 //check if pass not empty
if (password == ""||password== null){
alert("Please enter your password");
return false;
}
//checking that pass more than 7 digits
if (password.length<7){
  alert("Please enter your password with more than 7 digits");
  return false;
}

return true;
}


function f1(){
  if (validateform())
	  document.forms["myform"].submit();
  //window.location.href='student.html';
}
