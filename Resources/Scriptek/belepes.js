

function regisztralok() {
var login = document.getElementById("loginForm");
var reg = document.getElementById("registerId");
var x = login.offsetTop+login.offsetWidth/3;
var y = login.offsetLeft-login.offsetHeight+10;
login.style.opacity = "0";
reg.style.display = "block";
var speed = 100;
setTimeout(function() 
	{
		login.style.display = "none";
		reg.style.opacity = "1";
	},speed);
}