const socket = new WebSocket("ws://127.0.0.1:443");
socket.addEventListener("error", (event)=>{
	if(event.target.readyState==3){
	console.log("Az Aukcio kliens hibába ütközött. Ha nincs elindítva a Szerver ez normális. ");
	}
	
})



let waiting = true;
socket.addEventListener("message", (event) => {
	
		console.log(event.data);
			if(event.data =="id"){
				
				socket.send("AuctionClientID|"+USERID);
				
			}else if(event.data =="retry"){
				
				let tmp = setInterval(function(){
					socket.send("AuctionClientID|"+USERID);
					clearInterval(tmp);
				},100);
				
				
			}else if(event.data =="wait"){
				
				wait();
				
			}else{ 
			
			UPDATE(event.data);
			
			
			}
});

function wait(){
	console.log("Waiting mode");
		document.body.innerHTML="";
	
		document.body.setAttribute("class","curtain_closed");
		
		let screen = document.createElement("div");
						
			screen.setAttribute("class","screen");
			
			Text = document.createElement("p");
			Text.setAttribute("class","clock");
			if(AUCTIONS.length >0){
			let goal_date = new Date(AUCTIONS[0].Date).getTime();

			let timer = setInterval(function(){
				//milisecs, másodpercek, percek, órák, napok
				var distance = Math.max(0,goal_date - (new Date().getTime()));
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				if(hours < 10) hours = "0"+hours;
				if(minutes < 10) minutes = "0"+minutes;
				if(seconds < 10) seconds = "0"+seconds;
				Text.innerHTML = hours+":"+minutes+":"+seconds;
				if(distance == 0) location.reload();
			},1000);
			}else Text.innerHTML = "∞";
				screen.appendChild(Text);	
			
		
		document.body.appendChild(screen);
}
function  UPDATE(data){

	if(socket.readyState==3||data=="wait"&&waiting){
		wait();
		
	}else{
		
		
		
	}
	
	
}

let tmp = setInterval(function(){
	
	
	UPDATE("wait");
	clearInterval(tmp);
},1000);

socket.onopen= function(){
	waiting = false;
	clearInterval(tmp);
}
socket.onclose= function(){
	
	UPDATE("");
	
	
}