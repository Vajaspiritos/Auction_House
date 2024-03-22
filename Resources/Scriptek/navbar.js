function lenyit() 
{
	var bar = document.getElementById("drop-menusor");
	var gomb = document.getElementById("drop-btn");
	if(bar.style.display== "block"){bar.style.display = "none"; gomb.innerHTML = "↓"; gomb.style.color = "white";}else {	bar.style.display= "block"; gomb.innerHTML = "↑"; gomb.style.color = "black";}
	

	
}