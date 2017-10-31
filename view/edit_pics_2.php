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
			<canvas id='canvas' width='320' height='240' style='display:none border: 1px solid #333;'></canvas>
		</div>
		<img id='imgselect' src='' width='640' height='480' style='display:none'></img>
		</br>
		<div class="filters">
			<p id="filters_title">Add a filter to your picture:</p>
			<img id="metal" src="../filters/matrix.png" width="160px" height="120px"></img>
			</br>
			</br>
			<img id="orange" src="../filters/dolphin.png" width="160px" height="120px"></img>
			</br>
			<img id="filter3" src="../filters/ewok.png" width="160px" height="120px"></img>
			</br>
			<img id="filter4" src="../filters/beard.png" width="160px" height="120px"></img>
		</div>
			<img id="metal2" src="../filters/matrix.png" width="640px" height="480px" style="position:absolute;margin:-868px 60px;"></img>
			<img id="orange2" src="../filters/dolphin.png" width="640px" height="480px" style="position:absolute;margin:-868px 60px;"></img>
			<img id="filter32" src="../filters/ewok.png" width="640px" height="480px" style="position:absolute;margin:-868px 60px;"></img>
			<img id="filter42" src="../filters/beard.png" width="640px" height="480px" style="position:absolute;margin:-868px 60px;"></img>
	<div id='table'>
	</div>
<div id="upload">
<form action="" method="post" enctype="multipart/form-data">
    Or select an image to upload (.png only):
    <input type="file" name="fileToUpload" id="fileToUpload">
</form>
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

var imgselect = document.getElementById('imgselect');
var sel = document.getElementById('fileToUpload');
var fr;
var imgupload = 0;
sel.addEventListener('change', function(e) {
	var f = sel.files[0];
	fr = new FileReader();
	fr.onload = receivedData;
	fr.readAsDataURL(f);
	imgupload = 1;
	imgselect.style.display = 'initial';
});

function receivedData() {
	imgselect.src = fr.result;
}

function takePicture () {
	context.clearRect(0, 0, 320, 240);
	if (select == 1 || select == 2 || select == 3 || select == 4) {
		if (imgupload == 1) {
			context.drawImage(imgselect, 0, 0, 320, 240);
		}
		else {
		context.drawImage(video, 0, 0, 320, 240);
		}
		if (select == 1) {
			context.drawImage(metal, 0, 0, 320, 240);
		}
		else if (select == 2) {
			context.drawImage(orange, 0, 0, 320, 240);
		}
		else if (select == 3) {
			context.drawImage(filter3, 0, 0, 320, 240);
		}
		else if (select == 4) {
			context.drawImage(filter4, 0, 0, 320, 240);
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
	else if (select == 3)
		var incrust = document.getElementById('filter3');
	else if (select == 4)
		var incrust = document.getElementById('filter4');

	var image_canvas = canvas.toDataURL('image/png');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../controler/edit_pics_control.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
			console.log(this.responseText);
		}
	};
	var image_final = 'image_canvas='+image_canvas+'&image_incrust='+incrust.src;
	console.log(image_final);
	xhr.send(image_final);
location.reload();
}

//select filter
var metal = document.getElementById('metal');
var orange = document.getElementById('orange');
var filter3 = document.getElementById('filter3');
var filter4 = document.getElementById('filter4');
var select = 0;

var metal2 = document.getElementById('metal2');
var orange2 = document.getElementById('orange2');
var filter32 = document.getElementById('filter32');
var filter42 = document.getElementById('filter42');
metal2.style.visibility = 'hidden';
orange2.style.visibility = 'hidden';
filter32.style.visibility = 'hidden';
filter42.style.visibility = 'hidden';

metal.addEventListener('click', function () {
	if (select == 0) {
		metal2.style.visibility = 'visible';
		select = 1;
	}
	else if (select == 2) {
		orange2.style.visibility = 'hidden';
		select = 0;
	}
	else if (select == 3) {
		filter32.style.visibility = 'hidden';
		select = 0;
	}
	else if (select == 4) {
		filter42.style.visibility = 'hidden';
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
	else if (select == 3) {
		filter32.style.visibility = 'hidden';
		select = 0;
	}
	else if (select == 4) {
		filter42.style.visibility = 'hidden';
		select = 0;
	}
	else {
		orange2.style.visibility = 'hidden';
		select = 0;
	}
});

filter3.addEventListener('click', function () {
	if (select == 0) {
		filter32.style.visibility = 'visible';
		select = 3;
	}
	else if (select == 1) {
		metal2.style.visibility = 'hidden';
		select = 0;
	}
	else if (select == 2) {
		orange2.style.visibility = 'hidden';
		select == 0;
	}
	else if (select == 4) {
		filter42.style.visibility = 'hidden';
		select = 0;
	}
	else {
		filter32.style.visibility = 'hidden';
		select = 0;
	}
});

filter4.addEventListener('click', function () {
	if (select == 0) {
		filter42.style.visibility = 'visible';
		select = 4;
	}
	else if (select == 1) {
		metal2.style.visibility = 'hidden';
		select = 0;
	}
	else if (select == 2) {
		orange2.style.visibility = 'hidden';
		select == 0;
	}
	else if (select == 3) {
		filter32.style.visibility = 'hidden';
		select = 0;
	}
	else {
		filter42.style.visibility = 'hidden';
		select = 0;
	}
});

//display small pictures
var xhr = new XMLHttpRequest();
xhr.open('POST', '../controler/display_edit_pics.php', true);
xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
xhr.send();
xhr.onreadystatechange = function() {
	if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
		console.log(this.responseText);
		document.getElementById('table').innerHTML = this.responseText;
	}
};

//delete small pictures
function del_small (picture) {
	if (confirm('Do you want to delete this picture ?')) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../controler/delete_pics.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
				console.log(this.responseText);
			}
		}
		var image_name = 'image_name='+picture.src;
		xhr.send(image_name);
	}
location.reload();
};
</script>
</body>
</html>
