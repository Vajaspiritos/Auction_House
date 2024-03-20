if(USER_INVENTORY.length == 0){
	document.getElementById("info-container").style.visibility="hidden";
	document.getElementById("text").innerHTML="Jellenleg csóró vagy, és SEMMID nincs.";
	
}else{
								//lambda my beloved
	USER_INVENTORY.forEach( (Item) =>{
	

	for(let i=0;i<200;i++){	
		let elem = document.createElement('div');
		elem.setAttribute("class","Item");
		
		let kep = document.createElement('img');
		kep.setAttribute("class","Item_IMG");
		kep.src = Item["Image_src"];
		elem.appendChild(kep);
		elem.addEventListener("click",DisplayInfo(Item));
		
		document.getElementById("items-container").appendChild(elem);
		}
		
		
	} )
	
	DisplayInfo(USER_INVENTORY[0]);
	
	
	
}
if(document.getElementById("text").innerHTML=="Jellenleg csóró vagy, és SEMMID nincs.") 
{
document.getElementById("items-container").style.textAlign = "left";
document.getElementById("items-container").style.color = "white";

}else 
{
	document.body.style.overflow = "scroll";
}

function DisplayInfo(item){
	console.log("csa");
	document.getElementById("info_image").src = item['Image_src'];
	document.getElementById("info-description").innerHTML = "ezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszovegezegyhosszuszoveg";
	document.getElementById("info-name").innerHTML = item['Name'];
	document.getElementById("info-OG_owner").innerHTML = item['Original_owner'];
	document.getElementById("info-rarity").innerHTML = item['Rarity'];
	
	
	
	
	
}