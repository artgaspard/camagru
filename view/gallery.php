<?php
session_start();
include('header.php');
require('../controler/display_gallery.php');
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body>
	<div id='table_gallery'>
<?php
display_gallery();
?>
	</div>
<script>

function like(pic, image_id) {
	if (pic)
	{
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../controler/like.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && (this.status == 200)) {
				console.log(this.responseText);
				window.location.pathname = 'camagru/view/gallery.php';
			}	
		};
		var id = 'image_id='+image_id;
		xhr.send(id);
	}
};

function unlike(pic, image_id) {
	if (pic)
	{
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../controler/unlike.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && (this.status == 200)) {
				console.log(this.responseText);
				window.location.pathname = 'camagru/view/gallery.php';
			}	
		};
		var id = 'image_id='+image_id;
		xhr.send(id);
	}
};

function add_comment(pic, image_id) {
	if (pic)
	{
		var comm = prompt('Enter a comment:');
		if (comm)
		{
			console.log('comm != null');
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../controler/add_comment.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && (this.status == 200)) {
					console.log(this.responseText);
	//				window.location.pathname = 'camagru/view/gallery.php';
				}
			};
			var res = 'image_id='+image_id+'&comment='+comm;
			xhr.send(res);
		}
	}
};
</script>
</body>
</html>
