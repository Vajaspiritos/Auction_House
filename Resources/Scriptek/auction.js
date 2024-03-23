const socket = new WebSocket("ws://127.0.0.1:443");

socket.addEventListener("message", (event) => {
	
		
			if(event.data =="id"){
				
				socket.send("AuctionClientID|"+USERID);
				
			}else{ 
			
			UPDATE(event.data);
			
			
			}
});


function  UPDATE(data){
	
	if(socket.readyState==3||data=="wait"){
		console.log("Waiting mode");
		document.body.innerHTML="";
	
		document.body.setAttribute("class","curtain_closed");
		
		let screen = document.createElement("div");
			
			/* img = document.createElement("img");
				img.src ="../Resources/Images/BG/screen.png";		
				screen.appendChild(img);

*/				
			screen.setAttribute("class","screen");
			
			Text = document.createElement("p");
			Text.setAttribute("class","clock");
			let goal_date = new Date(AUCTIONS[0].Date).getTime();
			
			let timer = setInterval(function(){
				//milisecs, másodpercek, percek, órák, napok
				var distance = goal_date - (new Date().getTime());
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				if(hours < 10) hours = "0"+hours;
				if(minutes < 10) minutes = "0"+minutes;
				if(seconds < 10) seconds = "0"+seconds;
				Text.innerHTML = hours+":"+minutes+":"+seconds;
				
			},1000);
			
				screen.appendChild(Text);	
			
		
		document.body.appendChild(screen);
		
	}
	
	
}

socket.onclose= function(){
	
	UPDATE("");
	
	
}