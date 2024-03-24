if(USER_INVENTORY.length == 0){
	document.getElementById("info-container").style.visibility="hidden";
	document.getElementById("veglegesit").innerHTML="Jellenleg csóró vagy, és SEMMID nincs.";
	document.getElementById("veglegesit").style.visibility="visible";
	
	
}else{
								//lambda my beloved
	USER_INVENTORY.forEach( (Item) =>{
	for(let i = 0; i < 1; i++){
		
	
		let elem = document.createElement('div');
		elem.id =Item['ID'];
		elem.setAttribute("class","Item");
		
		let kep = document.createElement('img');
		kep.setAttribute("class","Item_IMG");
		kep.src = Item["Image_src"];
		
		elem.appendChild(kep);

		//elem.addEventListener("click",DisplayInfo(Item));
		elem.onclick= function(){

	document.getElementById("info_image").src = Item['Image_src'];
	document.getElementById("info-description").innerHTML = Item['Description'];
	document.getElementById("info-name").innerHTML = Item['Name'];
	document.getElementById("info-OG_owner").innerHTML = Item['Original_owner'];
	document.getElementById("info-rarity").innerHTML = Item['Rarity'];
	
								}
		
		document.getElementById("items-container").appendChild(elem);
		
		
		}
	} )
	
	document.getElementById("items-container").children[1].click();
	
	
	
}
if(document.getElementById("text").innerHTML=="Jellenleg csóró vagy, és SEMMID nincs.") 
{
document.getElementById("items-container").style.textAlign = "left";
document.getElementById("items-container").style.color = "white";

}
