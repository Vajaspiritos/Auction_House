



if(LAST_WORK <= 3600){
	
	
	document.getElementById("work").disabled = false;
	document.getElementById("timer").innerHTML = Math.floor(Math.max(0,(3600-LAST_WORK)/60));
	
}

function work(){
	window.location.href="work.php";
	
}