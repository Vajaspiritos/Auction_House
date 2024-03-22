var megnyomva = false;
setInterval(function() 
		{
			var bar = document.getElementById("drop-menusor");
			var gomb = document.getElementById("drop-btn");
			if(megnyomva == false && window.innerWidth <= 995) 
			{
				bar.style.display = "none";
				gomb.style.color = "white";
				gomb.innerHTML= "↑";
			}else 
			{
				bar.style.display = "block";
				gomb.style.color = "black";
				gomb.innerHTML= "↓";
			}
		}, 1)

function lenyit() 
{
	megnyomva = !megnyomva;
	

}