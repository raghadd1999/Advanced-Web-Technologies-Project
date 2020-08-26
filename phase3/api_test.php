<html>
<head>
</head>
<body>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$.ajax({
	type: "GET",
	dataType: "xml",
	url: "std_list_api.php?id=1",
	success: function(list) {
		console.log(list);
	}
});
</script>
</body>
</html>
