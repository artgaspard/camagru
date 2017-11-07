var password = document.getElementById("password");
var confirm_password = document.getElementById("confirmpw");

function check_pw()
{
	if (password.value != confirm_password.value)
	{
		confirm_password.setCustomValidity("Passwords don't match");
	}
	else
	{
		confirm_password.setCustomValidity('');
	}
}

password.onchange = check_pw;
confirm_password.onkeyup = check_pw;
