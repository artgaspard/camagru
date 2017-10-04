<?php
session_start();
if ($_SESSION['connect'] != 1)
{
	// changer path si necessaire
	$url = "http://".$_SERVER['HTTP_HOST']."/camagru/index.php";
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
	<p>EDIT PICTURES</p>
	</br>
	<div class="main">
		<div id="container">
			<video autoplay="true" id="videoElement">
			</video>
		</div>
		<button id="snap">Take picture</button>
		</br>
		</br>
		<div class="canvas">
			<canvas id="canvas" width="640" height="480" style="border:1px solid #333;"></canvas>
		</div>
		</br>
		<div class="filters">
			<p id="filters_title">Add a filter to your picture:</p>
			</br>
			<img id="metal" src="../filters/metal_frame.png" width="320px" height="240px"></img>
			</br>
			</br>
			<img id="orange" src="../filters/orange_frame.png" width="320px" height="240px"></img>
		</div>
	</div>
<script type="text/javascript">

//dispaly webcam
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

//take picture
var picture = document.getElementById('snap');

picture.addEventListener('click', function () {
	context.drawImage(video, 0, 0, 640, 480);
});

//select filter
var metal = document.getElementById('metal');
var orange = document.getElementById('orange');

metal.addEventListener('click', function () {
	context.drawImage(metal, 0, 0, 640, 480);
});

orange.addEventListener('click', function () {
	context.drawImage(orange, 0, 0, 640, 480);
});



</script>
</body>
</html>
