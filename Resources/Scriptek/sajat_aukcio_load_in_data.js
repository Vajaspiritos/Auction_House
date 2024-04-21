


if(USER_INVENTORY=="test"){
document.getElementById("host").innerHTML ="tárgy nélkül nem lehetseges";
document.getElementById("host").setAttribute("class","rejected");	
document.getElementById("auto").innerHTML ="tárgy nélkül nem lehetseges";
document.getElementById("auto").setAttribute("class","rejected");	
document.getElementById("host").disabled = true;
document.getElementById("auto").disabled = true;	
}else
if(USER_INVENTORY.length <5){

document.getElementById("host").innerHTML ="Sajnos legalább 5 tárgyra van szüksége.";
document.getElementById("host").setAttribute("class","rejected");	
document.getElementById("host").disabled = true;
}


function replace(mode){
	document.body.removeChild(document.getElementById("aukcio-container"));
	let iframe = document.getElementById("raktar");

		iframe.src = mode?"own_inventory.php":"auto_inventory.php";
		iframe.style.visibility="visible";
		
	let tomb =document.getElementsByClassName("aukcio")
		
		
	
	
	
	
	
}