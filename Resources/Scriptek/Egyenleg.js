



if(LAST_WORK >= 3600){
	
	
	document.getElementById("work").disabled = false;
	document.getElementById("timer").innerHTML = 0;
	
}else document.getElementById("timer").innerHTML = Math.floor(Math.max(0,(3600-LAST_WORK)/60));

document.getElementsByClassName("penz")[0].innerHTML= MONEY;
function work(){
	window.location.href="work.php";
	
}

let items= document.getElementsByClassName("tier-img-container")
for(let i=0;i<TIER;i++){
	items[i].classList.add("Bought");
	items[i].onclick = undefined;
	items[i].title = "Már megvásároltad ezt a rangot";
}

function buy(val){
	
	
	const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if(this.responseText==1){
		window.location.reload();
		
	}else alert("sajnos nincs elég pénze ennek a megvásárlásához.");
	
    }
  xhttp.open("POST", "buy.php?tier="+val, true);
  xhttp.send();
}