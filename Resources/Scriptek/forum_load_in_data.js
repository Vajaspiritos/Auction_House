if(testmode){
	for(let i=0;i<10;i++){
	let elem = document.createElement('div');
	elem.setAttribute("class","post");
	elem.id =0;
	if(false)elem.setAttribute("class","comment");
		let OP = document.createElement('div');
		OP.innerHTML="Posztoló ember felhasználóneve"+":";
		OP.setAttribute("class","post-op");
		elem.appendChild(OP);
		
		let div = document.createElement('div');
		div.setAttribute("class","text-img");
		let TEXT = document.createElement('p');
		TEXT.innerHTML="Ilyen egy átlagos komment, persze ez rövid, és még csak képek sincsenek, ahhoz el kell indítani az adatbázist.";
		TEXT.setAttribute("class","post-text");
		div.appendChild(TEXT);
		
		if(false){
			let IMG = document.createElement('img');
			IMG.src=POSTS[i]['Image_src'];
			IMG.setAttribute("class","post-image");
			div.appendChild(IMG);
			let br = document.createElement("br");
			div.appendChild(br);
		}
		elem.appendChild(div);
		let COMMENTS = document.createElement('button');
		COMMENTS.innerHTML="Comments:"+Math.floor(Math.random()*100);
		COMMENTS.setAttribute("class","post-comments");
		
		elem.appendChild(COMMENTS);
		
		let LIKES = document.createElement('button');
		LIKES.innerHTML="Likes:"+Math.floor(Math.random()*100);
		LIKES.setAttribute("class","post-likes");
		
		elem.appendChild(LIKES);
				let br = document.createElement("br");
			elem.appendChild(br);
		let DATE = document.createElement('span');
		DATE.innerHTML="2024-03-24  23:59";
		DATE.setAttribute("class","post-date");
		elem.appendChild(DATE);
		
		
	
	const Parent = document.getElementById("post_container");
	Parent.appendChild(elem);
	}
}else{

if(FocusOn){
	
	document.getElementById("Message").action = "Forum_post.php?"+FocusOn;
}


const Parent = document.getElementById("post_container");

for(let i=0;i<POSTS.length;i++){
	
	let elem = document.createElement('div');
	elem.setAttribute("class","post");
	elem.id =POSTS[i]['ID'];
	if(POSTS[i]['IsComment'])elem.setAttribute("class","comment");
		let OP = document.createElement('div');
		OP.innerHTML=POSTS[i]['OP']+":";
		OP.setAttribute("class","post-op");
		elem.appendChild(OP);
		
		let div = document.createElement('div');
		div.setAttribute("class","text-img");
		let TEXT = document.createElement('p');
		TEXT.innerHTML=POSTS[i]['Text'];
		TEXT.setAttribute("class","post-text");
		div.appendChild(TEXT);
		
		if(POSTS[i]['Image_src'] != null){
			let IMG = document.createElement('img');
			IMG.src=POSTS[i]['Image_src'];
			IMG.setAttribute("class","post-image");
			div.appendChild(IMG);
			let br = document.createElement("br");
			div.appendChild(br);
		}
		elem.appendChild(div);
		let COMMENTS = document.createElement('button');
		COMMENTS.innerHTML="Comments:"+POSTS[i]['Comments'];
		COMMENTS.setAttribute("class","post-comments");
		COMMENTS.onclick= function(){
			
			window.location.href="forum.php?Focus="+POSTS[i]['ID'];
		}
		elem.appendChild(COMMENTS);
		
		let LIKES = document.createElement('button');
		LIKES.innerHTML="Likes:"+POSTS[i]['Likes'];
		if(POSTS[i]["IsLiked"]){
		LIKES.setAttribute("class","post-alreadyLiked");
		}else LIKES.setAttribute("class","post-likes");
		LIKES.onclick= function(){
			
			//window.location.href="liking.php?for="+POSTS[i]['ID'];
			const xhttp = new XMLHttpRequest();		
					xhttp.onload = function() {
					 LIKES.innerHTML="Likes:"+this.responseText;
					 if(LIKES.classList.contains("post-alreadyLiked")){
						 LIKES.setAttribute("class","post-likes");
					 }else LIKES.setAttribute("class","post-alreadyLiked");
					}			
			  xhttp.open("POST", "liking.php?for="+POSTS[i]['ID'], true);
			  
			  xhttp.send();
			
		}
		elem.appendChild(LIKES);
				let br = document.createElement("br");
			elem.appendChild(br);
		let DATE = document.createElement('span');
		DATE.innerHTML=POSTS[i]['Date'];
		DATE.setAttribute("class","post-date");
		elem.appendChild(DATE);
		
		
	
	
	Parent.appendChild(elem);
}
if(CurrentPage != -1){
try{
	document.getElementById(POSTS[CurrentPage-10]['ID']).scrollIntoView();
	let next = document.createElement('button');
	next.onclick= function(){
		
		window.location.href="forum.php?Page="+0+"-"+(CurrentPage+10);
	//	window.location.href="forum.php?Page="+CurrentPage+"-"+CurrentPage+10;           ez akkora ha oldalak vannak és nme bővülő;
	}
	next.innerHTML ="Több poszt betöltése";
	Parent.appendChild(next);
}catch(err){
	document.getElementById(POSTS[POSTS.length-1]['ID']).scrollIntoView();
	let last = document.createElement('div');
		last.setAttribute("class","post-last");
	last.innerHTML ="Nincs több Poszt";
	Parent.appendChild(last);
}
}


}




