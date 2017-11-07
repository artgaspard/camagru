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
			<p id="filters_title">Add a filter to your picture</p>
			</br>
			<img id="metal" src="../filters/metal_frame.png" width="320px" height="240px"></img>
			</br>
		</div>
	</div>

<script type="text/javascript">
// display webcam
var video = document.querySelector("#videoElement");
var filter = document.querySelector("#metal");
			
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

//allow to take picture and save it
document.getElementById('snap').addEventListener('click', takePhoto, true);
function takePhoto () {
	context.drawImage(video, 0, 0, 640, 480);

	var saveButton = document.createElement('button');
	saveButton.id = 'save';
	saveButton.innerText = 'Save Picture';
	saveButton.addEventListener('click', savePhoto, true);
	document.body.appendChild(saveButton);
}

document.getElementById('metal').addEventListener('click', selectFilter, true);
function selectFilter () {
	context.drawImage(filter, 0, 0, 640, 480);
}

function savePhoto () {
	var image_canvas = canvas.toDataURL("image/png");

	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../controler/edit_pics_control.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			console.log(xhr.responseText);
		}
	};
	var image_final = 'image_canvas='+image_canvas;
	console.log(image_final);
	xhr.send(image_final);
}
//	var data = canvas.toDataURL("image/png");
//	data = data.replace("image/png", "image/octet-stream");
//	document.location.href = data;
</script>
</body>
</html>
