
const socket = new WebSocket("ws://127.0.0.1:443");

socket.addEventListener("error", (event)=>{
	if(event.target.readyState==3){
	console.log("A Chat kliens hibába ütközött. Ha nincs elindítva a Szerver ez normális. ");
	}
	
})

socket.addEventListener("message", (event) => {
	
		
			if(event.data =="id"){
				
				socket.send("ID|"+USERID+"|"+Name);
				document.getElementById("Messenger").removeAttribute("disabled");
			}else if(event.data.split(":")[0]=="CheckupCode_for_DisconnectDetection"){
				
				socket.send("CheckupCode_for_DisconnectDetection:"+event.data.split(":")[1]);
				console.log(event.data.split(":")[1]);
			}else{ 
			
			newMSG(event.data);
			
			
			}
});

var textEncoder = new TextEncoder();
document.getElementById("Messenger").addEventListener("keydown",(event)=>{
	if(socket.readyState==3){
		document.getElementById("Chatbox").innerHTML ="A Chat szerver le van állva.";
	}
	if(socket.readyState==1&&event.keyCode===13){
	let Element = document.getElementById("Messenger");
	if(Element.value.length >0&& textEncoder.encode(Element.value).length < 90){
		
		//let text = "Purple|"+Name+"|"+USERID+"|"+Element.value;
		//newMSG(text);
		console.log(textEncoder.encode(Element.value))
		socket.send(Element.value);
		Element.value = "";
		
		
		
	}
	
	}
	
	
	
})


function newMSG(msg){
	
	
	let BOX = document.getElementById("Chatbox");
	let Text = document.createElement("div");
	Text.id = "Message";
	console.log(msg)
	let data = msg.split("|");
		let Header = document.createElement("a");
		Header.id="name"
		Header.style.color = data[0];
		Header.innerText = data[1];
		let Header2 = document.createElement("a");
		Header2.id="id"
		Header2.innerText = "#"+data[2]+": ";
		let MSG = document.createElement("a");
		MSG.id="textMessage"
		MSG.innerText = data[3];
	
	Text.appendChild(Header);
	Text.appendChild(Header2);
	Text.appendChild(MSG);
	let AtBottom =BOX.scrollTop + BOX.clientHeight >= BOX.scrollHeight
	BOX.appendChild(Text);
	if(AtBottom)BOX.scrollTo(0,BOX.scrollHeight) 
}