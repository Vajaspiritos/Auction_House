document.getElementById("PP").src= USER_PFP_SRC;
document.getElementById("penz").innerHTML= USER_MONEY+" ¢";
document.getElementById("fnev").innerHTML= USER_NAME;
document.getElementById("email").innerHTML= USER_EMAIL;
if(TIER == 0){
	document.getElementById("Bedge").src = "../Resources/Images/Icons/Default_tier.png";
}else document.getElementById("Bedge").src = "../Resources/Images/Icons/Tier_"+TIER+".png";
if (typeof ERROR !== 'undefined') {
    alert(ERROR);
}

function deleteUser(){
	
	window.location = "DeleteUser.php";
}
	

