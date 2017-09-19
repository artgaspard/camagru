<?php
session_start();
if ($_SESSION['connect'] != 1)
{
	// changer path si necessaire
	$url = "http://".$_SERVER['HTTP_HOST']."/camagru/git/index.php";
	header("Refresh:5, url=$url");
	echo "You must be logged-in to use Camagru, redirecting to homepage... ";
	exit();
}
include("header.php");
?>
<html>
<head>
<link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
	EDIT PICTURES
	</br>
	<div class="main">
		<div id="container">
			<video autoplay="true" id="videoElement">
			</video>
		</div>

		<button id="snap">Take picture</button>
		</br>
		</br>
		<canvas id="canvas" width="640" height="480" style="border:1px solid #333;"></canvas>
	</div>


<script type="text/javascript">
var video = document.querySelector("#videoElement");
			
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

if (navigator.getUserMedia) {
	navigator.getUserMedia ({video: true}, handleVideo, videoError);
}

function handleVideo(stream) {
	video.src = window.URL.createObjectURL(stream);
}

function videoError(e) {
	alert("Can't connect with webcam");
}

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('videoElement');

document.getElementById('snap').addEventListener('click', function(e) {
	context.drawImage(video, 0, 0, 640, 480);
});
</script>
</body>
</html>

<?php
include "../control/edit_pics_control.php";
?>
