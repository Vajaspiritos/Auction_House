const socket = new WebSocket("ws://127.0.0.1:443");
window.speechSynthesis.cancel();
socket.addEventListener("error", (event)=>{
	if(event.target.readyState==3){
	console.log("Az Aukcio kliens hibába ütközött. Ha nincs elindítva a Szerver ez normális. ");
	}else{
		
		console.log(event.data);
	}
	
})




let waiting = true;
socket.addEventListener("message", (event) => {
	
		console.log("Auction got message: "+event.data);
			if(event.data =="id"){
					console.log("Auction trying to connect with user id: "+USERID);
				socket.send("AuctionClientID|"+USERID);
				
			}else if(event.data =="retry"){
				
				let tmp = setInterval(function(){
					console.log("Auction trying to connect with user id: "+USERID);
					socket.send("AuctionClientID|"+USERID);
					clearInterval(tmp);
				},100);
				
				
			}else if(event.data =="wait"){
				
				wait();
				
			}else{ 
			
			UPDATE(event.data);
			
			
			}
});
let test = false;
function wait(){
	console.log("Waiting mode");
		
	
		
		
		let screen = document.getElementById("screen");
			screen.setAttribute("class","screen");		
			
			
			let Text = document.getElementById("screen_text");
				Text.setAttribute("class","clock");
			
			if(test!=false||AUCTIONS.length >0){
			let goal_date = new Date(test!=false?test.getTime():AUCTIONS[0].Date).getTime(); 

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
				if(distance <= 0) location.reload();
			},1000);
			}else Text.innerHTML = "∞";
					
			
		
		
}
var base = 0;
window.onbeforeunload = function(event){
	
	window.speechSynthesis.cancel();
	
}
window.speechSynthesis.cancel();
var cl = 0;
document.body.addEventListener("click",event=>{

	let bg      = document.getElementById("bg");
let screen  = document.getElementById("screen_text");
let curtain = document.getElementById("curtain");
let manager = document.getElementById("manager");
let pedestal = document.getElementById("pedestal");
let item = document.getElementById("item");
let infos = document.getElementById("infos");
let NAME = document.getElementById("info_name");
let RARITY = document.getElementById("info_rarity");
let DESC = document.getElementById("info_desc");
let OG = document.getElementById("info_og");
let rarity = 0;
let name = "";
let og = "";
let desc = "";
let item_id = 0;
	if(cl==0){
				let utterance = new SpeechSynthesisUtterance();
					utterance.pitch =1;
					utterance.rate =1;
					utterance.text ="Na hellóka bellóka, békapicsa. Veri skibidi, fannum tax, gyatt, ez vajon már elég hosszú?";
				window.speechSynthesis.speak(utterance)
	

	
	curtain.setAttribute("class","curtain_on");
						let t= setInterval(function(){
							
							curtain.setAttribute("class","");
							clearInterval(t);
						},7000);
						
						bg.setAttribute("class","background_formalities");
						screen.setAttribute("class","welcome");
						screen.innerHTML="Üdvözöljük!";
						cl++;
	}else{
		
		curtain.setAttribute("class","curtain_off");
		var iteration = 0;
						let t= setInterval(function(){
							bg.backgroundImage="url(../Resources/Images/BG/bg_"+rarity+".png)";
							pedestal.backgroundImage="url(../Resources/Images/BG/pedestal_"+rarity+".png)";
							manager.setAttribute("class","manager_presenting");
							item.src="../Resources/Images/Items/"+item_id+".png";
							item.style.visibility= "visible";
							infos.style.visibility= "visible";
							NAME.innerHTML = name;
							OG.innerHTML = og;
							RARITY.innerHTML = rarity;
							DESC.innerHTML = desc;
							
							iteration++;
							curtain.setAttribute("class","curtain_on");
							if(iteration==2){	
							curtain.setAttribute("class","");
							clearInterval(t);
							}
						},7000);
		
	}
	
})


function  UPDATE(data){
	let bg      = document.getElementById("bg");
let screen  = document.getElementById("screen_text");
let curtain = document.getElementById("curtain");
let manager = document.getElementById("manager");
let pedestal = document.getElementById("pedestal");
let item = document.getElementById("item");
let infos = document.getElementById("infos");
let NAME = document.getElementById("info_name");
let RARITY = document.getElementById("info_rarity");
let DESC = document.getElementById("info_desc");
let OG = document.getElementById("info_og");


	if(socket.readyState==3||data=="wait"&&waiting){
		wait();
		
	}else{
		//console.log(data);
		let parts = data.split("|");
		
		if(parts[0]=="ChangedPrice"){
			
				//itt írja átt a kijelzőn a cash összeget;
				moneycountup(parts[1]);
		}else{
				let stage = parts[0];
				let pitch = parts[1];
				let speed = parts[2];
				let msg = parts[3];
				
				let utterance = new SpeechSynthesisUtterance();
				utterance.addEventListener("end",event=>{
					if(curtain.classList.length==0&& stage != 2){
					curtain.setAttribute("class","curtain_off");
					let t= setInterval(function(){
	
							if(curtain.classList.contains("curtain_off"))curtain.setAttribute("class","curtain_closed");
							clearInterval(t);
							
						},7000);
					}
					
					if(stage==3){
						window.location.reload();
						
					}
					
				})
					utterance.pitch =pitch;
					utterance.rate =speed;
					utterance.text =msg;
				window.speechSynthesis.speak(utterance)
				
				
				if(stage==2){

					let rarity 			= parts[4];
					let rarity_name 	= parts[10];
					let name 			= parts[5];
					let og 				= parts[6];
					let desc 			= parts[7];
					let item_src 		= parts[8];
					let baseprice 		= parts[9];
					
							
				
				var iteration = 0;
				if(curtain.classList.contains("curtain_closed")){ 
				
				iteration++;
				tick();
						curtain.setAttribute("class","");
				}else{ curtain.setAttribute("class","curtain_off");
						let t= setInterval(function(){
							tick();
							if(iteration==2){
								
							curtain.setAttribute("class","");
							clearInterval(t);
							}
						},7000);
				
				}
				function tick(){
							bg.setAttribute("class","bg"+rarity);
							//bg.backgroundImage="url(../Resources/Images/BG/bg_"+rarity+".png)";
							//pedestal.backgroundImage="url(../Resources/Images/BG/pedestal_"+rarity+".png)";
							pedestal.setAttribute("class","p"+rarity);
							manager.setAttribute("class","manager_presenting");
							item.src=item_src;
							item.style.visibility= "visible";
							infos.style.visibility= "visible";
							NAME.innerHTML = name;
							OG.innerHTML = og;
							RARITY.innerHTML = rarity_name;
							DESC.innerHTML = desc;
							
							if(baseprice != base){
							base = 0;
							moneycountup(baseprice);
							screen.setAttribute("class","money");
							}
							
							
							iteration++;
							curtain.setAttribute("class","curtain_on");
							
				}
				
				}
				if(stage==1){
						curtain.setAttribute("class","curtain_on");
						let t= setInterval(function(){
							
							curtain.setAttribute("class","");
							clearInterval(t);
						},7000);
						
						bg.setAttribute("class","background_formalities");
						screen.setAttribute("class","welcome");
						screen.innerHTML="Üdvözöljük!";
					}
					
					if(stage==3){
						
						
						curtain.setAttribute("class","curtain_off");
						let t= setInterval(function(){
							
							curtain.setAttribute("class","curtain_closed");
							clearInterval(t);
						},7000);
						
						//bg.setAttribute("class","background_formalities");
						screen.setAttribute("class","goodbye");
						screen.innerHTML="Várjuk vissza!";
						
						
						
					}
		
		
		}

	}
	
	
}

function moneycountup(amount){
	let screen  = document.getElementById("screen_text");
	console.log("amount: "+amount)
	
	amount = parseInt(amount);
	base = Math.max(base,0)
	
	
	let step = Math.max(1,Math.floor(1 *((amount-base)/100)));
	
	
	if(step== NaN) step = 1;
	let delay = 10
	let i = setInterval(function(){
		
		base += step;
		
		base = Math.min(amount, base);
		
		screen.innerHTML="¢"+base;
		if(base == amount) clearInterval(i);
	},delay);

	
}

let tmp = setInterval(function(){
	
	
	UPDATE("wait");
	clearInterval(tmp);
},1000);

if(AUCTIONS == 'test'){
	
	


test  = new Date(new Date().getTime()+3600000);
wait();	
}

socket.onopen= function(){
	waiting = false;
	clearInterval(tmp);
}
socket.onclose= function(){
	
	wait();
	
	
}