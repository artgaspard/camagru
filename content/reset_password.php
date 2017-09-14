<?php
include ("header.php");
?>
<html>
	<body>
		</br>
		CHANGE YOUR PASSWORD
		</br>
		</br>
		<form action="" method="POST">
		<input type="password" name="password" id="password" placeholder="New password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must be at least 6 characters long, and contain at least one number and one uppercase and lowercase letter." required/>
		</br>
		<input type ="password" name="confirmpw" id="confirmpw" placeholder="Confirm new password" required/>
		</br>
		<button type="submit" name="submit" class="pure-button-primary">Submit</button>
		</br>
		</form>
	<script src="password_match.js" type="text/javascript"></script>
	</body>
</html>
<?php
include ("../control/reset_password_control.php");
?>
