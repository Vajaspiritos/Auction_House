

function lenyit() 
{

			if(document.getElementById("drop-menusor").style.display == "none" || document.getElementById("drop-menusor") == null)
			{
					document.getElementById("drop-menusor").style.display = "block";
				document.getElementById("drop-btn").innerHTML= "↓";
					document.getElementById("drop-btn").style.color = "black";	
					

			}else 
			{
				
				document.getElementById("drop-menusor").style.display = "none";
			
						document.getElementById("drop-btn").innerHTML= "↑";
				document.getElementById("drop-btn").style.color = "white";
			}


	
}