if(USER_INVENTORY=="test"){
	
		
	for(let i = 0; i < 100; i++){
		
	
		let elem = document.createElement('div');
		elem.id =0;
		elem.setAttribute("class","Item");
		
		let kep = document.createElement('img');
		kep.setAttribute("class","Item_IMG");
		kep.src = "../Resources/Images/icons/Default_Item.png";
		
		elem.appendChild(kep);

		//elem.addEventListener("click",DisplayInfo(Item));
		elem.onclick= function(){

	document.getElementById("info_image").src = "../Resources/Images/icons/Default_Item.png";
	document.getElementById("info-description").innerHTML = "ez egy leírás mint: 200 éves ókori tányér, ami a gonosz varázsló Gollam kezében volt!";
	document.getElementById("info-name").innerHTML = "A egy gyűrű #"+Math.floor(Math.random()*1000);
	document.getElementById("info-OG_owner").innerHTML = "Gollam";
	document.getElementById("info-rarity").innerHTML = "nagyon ritka";
	
								}
		
		document.getElementById("items-container").appendChild(elem);
		
		
		}
	
	
	document.getElementById("items-container").children[1].click();
	
	
}else
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
