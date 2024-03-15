if(USER_INVENTORY.length == 0){
	
	
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


function DisplayInfo(item){
	document.getElementById("info_image").src = item['Image_src'];
	document.getElementById("info-description").innerHTML = item['Description'];
	document.getElementById("info-name").innerHTML = item['Name'];
	
	
	
	
	
}