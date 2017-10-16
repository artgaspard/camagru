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
	<div class="main">
		<div id="container">
			<video autoplay="true" id="videoElement">
			</video>
		</div>
		<button id='snap'>Take picture</button>
		</br>
		<div class="canvas">
			<p id="pics_title">My pictures:</p>
			<canvas id='canvas' width='320' height='240' style='border: 1px solid #333;'></canvas>
		</div>
		</br>
		<div class="filters">
			<p id="filters_title">Add a filter to your picture:</p>
			<img id="metal" src="../filters/metal_frame.png" width="160px" height="120px"></img>
			</br>
			</br>
			<img id="orange" src="../filters/orange_frame.png" width="160px" height="120px"></img>
		</div>
		<div class="picture_fil">
			<img id="metal2" src="../filters/metal_frame.png" width="640px" height="480px" style="margin: -615px 60px; z-index:1"></img>
			<img id="orange2" src="../filters/orange_frame.png" width="640px" height="480px" style="margin: -615px 60px;"></img>
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

//take picture
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('videoElement');  
document.getElementById('snap').addEventListener('click', takePicture, true);

function takePicture () {
	context.clearRect(0, 0, 320, 240);
	if (select == 1 || select == 2) {
		context.drawImage(video, 0, 0, 320, 240);
		if (select == 1) {
			context.drawImage(metal, 0, 0, 320, 240);
		}
		else if (select == 2) {
			context.drawImage(orange, 0, 0, 320, 240);
		}
	}
	else {
		alert('You must select a filter before taking a picture :)');
	}

//save picture on server
	if (select == 1)
		var incrust = document.getElementById('metal');
	else if (select == 2)
		var incrust = document.getElementById('orange');

	var image_canvas = canvas.toDataURL('image/png');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../controler/edit_pics_control.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			console.log(xhr.responseText);
		}
	};
	var image_final = 'image_canvas='+image_canvas+'&image_incrust='+incrust.src;
	console.log(image_final);
	xhr.send(image_final);

//create download button
	if (dlButton) {
		document.body.removeChild(dlButton);
	}
	else {
	var dlButton = document.createElement('button');
	dlButton.id = 'download';
	dlButton.innerText = 'Download Picture';
	dlButton.addEventListener('click', dlPhoto, true);
	document.body.appendChild(dlButton);
	}
}

//download picture
function dlPhoto () {
	var data = canvas.toDataURL('image/png');
	data = data.replace('image/png', 'image/octet-stream');
	document.location.href = data;
}

//select filter
var metal = document.getElementById('metal');
var orange = document.getElementById('orange');
var select = 0;

var metal2 = document.getElementById('metal2');
var orange2 = document.getElementById('orange2');
metal2.style.visibility = 'hidden';
orange2.style.visibility = 'hidden';

metal.addEventListener('click', function () {
	if (select == 0) {
		metal2.style.visibility = 'visible';
		select = 1;
	}
	else if (select == 2) {
		orange2.style.visibility = 'hidden';
		select = 0;
	}
	else {
		metal2.style.visibility = 'hidden';
		select = 0;
	}
});

orange.addEventListener('click', function () {
	if (select == 0) {
		orange2.style.visibility = 'visible';
		select = 2;
	}
	else if (select == 1) {
		metal2.style.visibility = 'hidden';
		select = 0;
	}
	else {
		orange2.style.visibility = 'hidden';
		select = 0;
	}
});

</script>
</body>
</html>
