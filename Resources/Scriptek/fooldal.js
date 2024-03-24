


const parentElement = document.getElementById("aukcio-container");
AUCTIONS.forEach( auction => {
	
	let elem = document.createElement("tr");
		elem.setAttribute("class","row");
	
		let elem2 = document.createElement("td");
			let elem2_1 = document.createElement("span");
				elem2_1.innerHTML = auction["Date"];
			elem2.appendChild(elem2_1);
		elem.appendChild(elem2);
		
		let elem3 = document.createElement("td");
			let elem3_1 = document.createElement("span");
				elem3_1.innerHTML = auction["Tier"];
			elem3.appendChild(elem3_1);
		elem.appendChild(elem3);
		
		let elem4 = document.createElement("td");
			let elem4_1 = document.createElement("span");
				elem4_1.innerHTML = auction["Manager"];
			elem4.appendChild(elem4_1);
		elem.appendChild(elem4);
		
			
	
	
	parentElement.appendChild(elem);
} )










