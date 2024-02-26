var megnyomva = false;
function legordul() 
{
	var lista = document.getElementById("publish");
	var tartalom = document.getElementById("pTartalom")
	if(megnyomva==false) 
	{
		megnyomva= true;
		lista.style.height = "400px";
		setTimeout(function() 
			{
				tartalom.style.display = "block";
			},1000)
		tartalom.style.opacity = "0.3";
	}
	else 
	{
		megnyomva = false
		lista.style.height = "1px";
		var ido = tartalom.offsetHeight;
		setTimeout(function() {	tartalom.style.display = "none";  tartalom.style.opacity = "1";} ,ido)

	}


}