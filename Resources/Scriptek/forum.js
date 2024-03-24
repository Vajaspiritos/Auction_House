var megnyomva = false;
function legordul() 
{
	var lista = document.getElementById("publish");
	var tartalom = document.getElementById("pTartalom")
	if(megnyomva==false) 
	{
		//media query cuccok. ha a képernyő akkora mint a mac-en akkor 
		megnyomva= true;
		lista.style.height = "45%"; //35

	}
	else 
	{
		megnyomva = false
		lista.style.height = "4%"; //8.5


	}


}
