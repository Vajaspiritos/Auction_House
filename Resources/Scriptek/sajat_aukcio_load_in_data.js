



if(USER_INVENTORY.length <5){

document.getElementsByClassName("aukcio own")[0].innerHTML ="Sajnos egész aukciós esemény rendezéséhez legalább 5 tárgyra van szüksége.";
document.getElementsByClassName("aukcio own")[0].setAttribute("class","aukcio rejected");	
}


function replace(mode){
	document.body.removeChild(document.getElementById("aukcio-container"));
	let iframe = document.getElementById("raktar");

		iframe.src = mode?"own_inventory.php":"auto_inventory.php";
		iframe.style.visibility="visible";
		
	let tomb =document.getElementsByClassName("aukcio")
		
		
	
	
	
	
	
}