
var megnyomva = false;
function lenyit() 
{
			if(megnyomva== true)
			{
				
				
				document.getElementById("drop-menusor").classList.remove("active");
				document.getElementById("drop-menusor").classList.add("inactive");
				document.getElementsByClassName("inactive")[0].style.animation = "eltunes 1s";
				document.getElementById("drop-btn").innerHTML= "↓";
				document.getElementById("drop-btn").style.color = "white";	
		

					

			}else 
			{
				
				document.getElementById("drop-menusor").classList.add("active");
				document.getElementById("drop-menusor").classList.remove("inactive");
				document.getElementsByClassName("active")[0].style.animation = "attones 1s";
				document.getElementById("drop-btn").innerHTML= "↑";
				document.getElementById("drop-btn").style.color = "black";
			}
megnyomva = !megnyomva;
	
}