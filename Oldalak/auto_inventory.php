<?php
include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Oldalak/Inventory.php';

?>
<head>
	<link rel="stylesheet" href="../Resources/CSS/own_inventory.css">
	</head>
<script>

let array = document.getElementById("items-container").children;
let selected = ["auto"];

function update(){
	
	document.getElementById("text").innerHTML = (selected.length-1)+" tárgy kiválasztva";
	document.getElementById("SELECTED").innerHTML = JSON.stringify(selected);
	if(selected.length >1){
	document.getElementById("veglegesit").style.visibility = "visible";
	document.getElementById("sendit").style.visibility = "visible";
	document.getElementById("info-container").style.marginTop = "0vh";
	document.getElementById("items-container").style.paddingTop = "6em";
	
	}else{ document.getElementById("veglegesit").style.visibility = "hidden";
	document.getElementById("sendit").style.visibility = "hidden";
	document.getElementById("info-container").style.marginTop = "-10vh";
	document.getElementById("items-container").style.paddingTop = "1em";
	}
}

for(let i=1;i<array.length;i++){ //első a span
	let Item = USER_INVENTORY[i];
	array[i].addEventListener("click",function(){
		
		if(array[i].classList.contains("selected")){
			console.log(selected)
			 selected.splice(selected.indexOf(String(array[i].id)),1);
			
			array[i].classList.remove("selected");
		}else{
			array[i].classList.add("selected");
			selected.push(array[i].id);
		}
		
		update();
		
	});
	
}

</script>