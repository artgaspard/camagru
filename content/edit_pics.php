<?php
session_start();
include("header.php");
?>

<html>
	<body>
		</br>
		EDIT
		</br>
		<div class="video" alt="webcam">
			<video autoplay id="video" width="500" height="auto">
			</video>
		</div>
	</body>
</html>

<script type="text/javascript">
var video = document.querySelector("#video");

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;

if (navigator.getUserMedia)
{
	navigator.getUserMedia({video: true}, handleVideo, videoError)
}

</script>
