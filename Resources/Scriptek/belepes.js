

function regisztralok() {
var login = document.getElementById("loginForm");
var reg = document.getElementById("registerId");
login.style.opacity = "0";
reg.style.display = "block";
var speed = 100;
setTimeout(function() 
	{
		login.style.display = "none";
		reg.style.opacity = "1";
	},speed);
}

function loginolok() 
{
var login = document.getElementById("loginForm");
var reg = document.getElementById("registerId");
reg.style.opacity = "0";
login.style.display = "block";
reg.style.display = "none";
var speed = 50;
setTimeout(function() 
	{
		
		login.style.opacity = "1";
	},speed);
}

