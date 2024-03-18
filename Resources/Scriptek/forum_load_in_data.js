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
	
		let TEXT = document.createElement('p');
		TEXT.innerHTML=POSTS[i]['Text'];
		TEXT.setAttribute("class","post-text");
		elem.appendChild(TEXT);
		
		if(POSTS[i]['Image_src'] != null){
			let IMG = document.createElement('img');
			IMG.src=POSTS[i]['Image_src'];
			IMG.setAttribute("class","post-image");
			elem.appendChild(IMG);
		}
		
		let COMMENTS = document.createElement('button');
		COMMENTS.innerHTML="Comments:"+POSTS[i]['Comments'];
		COMMENTS.setAttribute("class","post-comments");
		COMMENTS.onclick= function(){
			
			window.location.href="forum.php?Focus="+POSTS[i]['ID'];
		}
		elem.appendChild(COMMENTS);
		
		let LIKES = document.createElement('button');
		LIKES.innerHTML="Likes:"+POSTS[i]['Likes'];
		LIKES.setAttribute("class","post-likes");
		LIKES.onclick= function(){
			
			window.location.href="liking.php?for="+POSTS[i]['ID'];
		}
		elem.appendChild(LIKES);
		
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










