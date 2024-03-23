
var megnyomva = false;
function lenyit() 
{
			if(document.getElementById("drop-menusor").style.display == "block")
			{
				document.getElementById("drop-btn").innerHTML= "↓";
				document.getElementById("drop-btn").style.color = "white";	
				document.getElementById("drop-menusor").style.display = "none";
					

			}else 
			{
				
				document.getElementById("drop-menusor").style.display = "block";
				document.getElementById("drop-btn").innerHTML= "↑";
				document.getElementById("drop-btn").style.color = "black";
			}
megnyomva = !megnyomva;
	
}