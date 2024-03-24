var megnyomva = false;
function legordul() 
{
	if(megnyomva==false) 
	{
		//media query cuccok. ha a képernyő akkora mint a mac-en akkor 
		document.getElementById("publish").classList.remove("eltunt");
		document.getElementById("publish").classList.add("megjelent");
			document.getElementsByClassName("megjelent")[0].style.animation = "attunesDoboz 0.2s";
	}
	else 
	{
		document.getElementById("publish").classList.add("eltunt");
		document.getElementById("publish").classList.remove("megjelent");
			document.getElementsByClassName("eltunt")[0].style.animation = "eltunesDoboz 0.2s";

	}
		megnyomva = !megnyomva;

}
