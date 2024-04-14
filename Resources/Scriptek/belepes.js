function regisztralok() {regBec
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

function AdatokEllenorzes() 
{

let sikertelen = "";
let regexUres = /\w/;
let regexJelszo = /\w{0,}.[?!+%$€#&@~.-]/;
let regexBank = /[0-9]{4}[-][0-9]{4}[-][0-9]{4}[-][0-9]{4}/;
let regexEmail = /\w+[@]+\w+\.+\w/; //először megnézi hogy valamilyen karakterrel kezdődik e, majd hogy azt kukac követi, majd hogy pont követi, majd hogy betűk követik
let regEmail = document.getElementById("regEmail").value;
if(!regexEmail.test(regEmail)){sikertelen+="a";}

let regUname= document.getElementById("regUname").value;
if(!regexUres.test(regUname)){sikertelen+="b";}

let regPass = document.getElementById("regPass").value;
if(!regexJelszo.test(regPass) || regPass.length < 5){sikertelen+="c";}

let regPassA =document.getElementById("regPassA").value;
if(!regexJelszo.test(regPassA) || regPassA.length < 5){sikertelen+="d";}

//a 2 jelszo nem egyzik
if(regPass != regPassA) {sikertelen+="CD";}

let regBank = document.getElementById("regBank").value;
if(!regexBank.test(regBank) || regBank.length != 19) {sikertelen+="e"} 

let regAnya =document.getElementById("regAnya").value;
if(!regexUres.test(regAnya)){sikertelen+="f"}

let regAllat = document.getElementById("regAllat").value;
if(!regexUres.test(regAllat)){sikertelen+="g"}

let regSzul = document.getElementById("regSzul").value;
if(!regexUres.test(regSzul)){sikertelen+="h"}

let regBec =document.getElementById("regBec").value;
if(!regexUres.test(regBec)){sikertelen+="i"}
alert(sikertelen);
event.preventDefault();
if(sikertelen != "") {event.preventDefault();}

}