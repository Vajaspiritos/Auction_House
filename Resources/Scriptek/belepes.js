

function regisztralok() {
var login = document.getElementById("loginForm");
var reg = document.getElementById("registerId");
login.style.opacity = "0";
reg.style.display = "block";
var speed = 100;
document.getElementById("hiba_doboz").style.display = "none";
setTimeout(function() 
	{
		document.getElementById("check_list").style.display = "block";
		login.style.display = "none";
		reg.style.opacity = "1";
	},speed);
}

function loginolok() 
{
	document.getElementById("hiba_doboz").style.display = "block";
	document.getElementById("check_list").style.display = "none";
let login = document.getElementById("loginForm");
let reg = document.getElementById("registerId");
reg.style.opacity = "0";
login.style.display = "block";
reg.style.display = "none";
let speed = 50;
setTimeout(function() 
	{
		
		login.style.opacity = "1";
	},speed);
}

if(typeof ERROR !== 'undefined') {document.getElementById('hiba').innerHTML = ERROR;}

function kihuzas(melyiket,helyes) 
{
let lista = document.getElementsByClassName("listaElem");
let elem = lista[melyiket-1].children[0];

if(helyes == true) {
	lista[melyiket-1].children[0].style.textDecoration = "none";
	if(lista[melyiket-1].innerHTML.split(" :)").length <= 1){
	lista[melyiket-1].innerHTML+=" :)";
}
	
}
else 
{
	lista[melyiket-1].children[0].style.textDecoration = "line-through";
	lista[melyiket-1].innerHTML = lista[melyiket-1].innerHTML.split(" :)")[0];
}
	
}

function helyesek(jel) 
{
	let lista = document.getElementsByClassName("listaElem");
	let db = 0;
	for (i = 0; i < lista.length; i++) 
	{
		if(lista[i].innerHTML.split(jel).length >1) 
		{
			db++;
		}
	}
	return db;
}

function AdatokEllenorzes(elem) 
{

let regexUres = /[\w]/;
let regexJelszo = /[?!+%$€#&@~.-]/;
let regexBank = /[0-9]{4}[-][0-9]{4}[-][0-9]{4}[-][0-9]{4}/;
let regexEmail = /\w+[@]+\w+\.+\w/; //először megnézi hogy valamilyen karakterrel kezdődik e, majd hogy azt kukac követi, majd hogy pont követi, majd hogy betűk követik
let db = 0;
for(i = 0; i < document.getElementsByClassName("regElem").length; i++) 
{
	if(regexUres.test(document.getElementsByClassName("regElem")[i].value)) 
	{
		db++;
	}
} 
if(db <document.getElementsByClassName("regElem").length) {kihuzas(5,false)}else {kihuzas(5,true)}
if(elem =="email")
	{	
			if(regexEmail.test(document.getElementById("regEmail").value))
			{
				kihuzas(1,true);
			}else 
			{
				kihuzas(1,false);
				
			}
		
	}
if(elem =="jelszo")
	{	

			if(document.getElementById("regPass").value.length >= 5)
			{
				if(regexJelszo.test(document.getElementById("regPass").value) && regexUres.test(document.getElementById("regPass").value))
				{
					kihuzas(2,true);
				}else 
				{
					kihuzas(2,false);
				}
				if(document.getElementById("regPass").value == document.getElementById("regPassA").value && regexJelszo.test(document.getElementById("regPass").value) 
					&& regexUres.test(document.getElementById("regPass").value)) 
					{
					kihuzas(3,true);
					}else {kihuzas(3,false);}
				
			}else 
			{
				kihuzas(2,false);
				
			}
		
	}
	if(elem =="jelszoA") 
	{
		if(document.getElementById("regPass").value.length >= 5)
			{
				if(regexJelszo.test(document.getElementById("regPass").value) && regexUres.test(document.getElementById("regPass").value) &&
					document.getElementById("regPass").value == document.getElementById("regPassA").value) 
				{
					kihuzas(3,true);
				}else 
				{
					kihuzas(3,false);
				}
				
			}else 
			{
				kihuzas(3,false);
				
			}
	}
if(elem =="bank") 
{
	if(regexBank.test(document.getElementById("regBank").value)) 
	{
		kihuzas(4,true);
	}else {kihuzas(4,false)}
}

	if(helyesek(" :)") != 5) {event.preventDefault();}

}

function bezar() {
	document.getElementById("ForgotContainer").style.display = "none";
	document.getElementById("blur").style.display = "none";

}
function megjelenit() 
{
	document.getElementById("ForgotContainer").style.display = "block";
	document.getElementById("ForgotContainer").style.zIndex = "5";
	document.getElementById("blur").style.zIndex = "1";
	document.getElementById("blur").style.display = "block";
}

