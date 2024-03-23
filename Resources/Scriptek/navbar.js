
var megnyomva = false;
document.getElementById("drop-btn").innerHTML= "→";
function lenyit() 
{
	document.getElementById("drop-btn").style.transition= "0.4s";
			if(megnyomva== true)
			{			
				document.getElementById("drop-menusor").classList.remove("active");
				document.getElementById("drop-menusor").classList.add("inactive");
				document.getElementsByClassName("inactive")[0].style.animation = "eltunes 1s";
				document.getElementById("drop-btn").style.rotate= "0deg";
				document.getElementById("drop-btn").style.color = "white";	
		

					

			}else 
			{
				
				document.getElementById("drop-menusor").classList.add("active");
				document.getElementById("drop-menusor").classList.remove("inactive");
				document.getElementsByClassName("active")[0].style.animation = "attones 1s";
				document.getElementById("drop-btn").style.rotate= "-180deg";
				document.getElementById("drop-btn").style.color = "black";
			}
megnyomva = !megnyomva;
	
}