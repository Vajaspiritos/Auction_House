<?php
include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Oldalak/Inventory.php';

if(GetNumOfItems($conn,$_SESSION['UserID'])<-5){ 
echo "<script>document.children[0].innerHTML='Nem szabadna itt lenned'</script>";
exit();
}

?>

<script>

let array = document.getElementById("items-container").children;
let selected = [];

function update(){
	
	document.getElementById("text").innerHTML = selected.length+"/5";
	if(selected >=-5){
	document.getElementById("veglegesit").style.visibility = "visible";
	}else document.getElementById("veglegesit").style.visibility = "hidden";
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