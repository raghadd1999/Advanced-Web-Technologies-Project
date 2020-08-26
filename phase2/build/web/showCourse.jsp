<!DOCTYPE HTML>
<html>
<head>
	<title>KSU</title>
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="web1.css" />
	<script src="valid4.js"></script>
</head>
<body>

	<header id="header">
		<div id="logo">
			<img src ="logo.png" alt ="logo" >
			<h1><a href="index.html">Welcome to KSU</a></h1>
		</div>
		
		<div class="welcome">
			Welcome <a href="index.html">Sign Out</a>
		</div>		
		<nav id="nav">
			<ul>
				<li><a href="index.html">Homepage</a></li>
			</ul>
		</nav>
	</header>
	
	<div id="page">
	
		<section style="text-align: center;">
			<header class="major">
				<h2>Course Information</h2>
			</header>
		</section>

		<section>
			<h3>Course Information</h3>
			<table>
				<tr>
					<th width="10%">ID:</th>
					<td>${Course.id}</td>
				</tr>
				<tr>
					<th>Name:</th>
					<td>${Course.name}</td>
				</tr>
				<tr>
					<th>Field:</th>
					<td>${Course.field}</td>
				</tr>
				<tr>
					<th>Description:</th>
					<td>${Course.description}</td>
				</tr>
			</table>
		</section>
		<section>
			<h3>Instructor Information</h3>
			<table>
				<tr>
					<th width="10%">ID:</th>
					<td>${Course.instructor.id}</td>
				</tr>
				<tr>
					<th>Name:</th>
					<td>${Course.instructor.name}</td>
				</tr>
				<tr>
					<th>Email:</th>
					<td>${Course.instructor.email}</td>
				</tr>
				<tr>
					<th>Speciality:</th>
					<td>${Course.instructor.speciality}</td>
				</tr>
			</table>
		</section>
		
	</div>
	
	<footer id="copyright">
		<p>Copyrights KSU courses.</p>
	</footer>
</body>
</html>