<?php
session_start();
include('header.php');
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body>
	<div id='table_gallery'>
	</div>
<script>
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../controler/display_gallery.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
			console.log(this.responseText);
			document.getElementById('table_gallery').innerHTML = this.responseText;
		}
	};
</script>
</body>
</html>
