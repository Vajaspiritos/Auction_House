document.getElementById("PP").src= USER_PFP_SRC;
document.getElementById("penz").innerHTML= USER_MONEY+" ¢";
document.getElementById("fnev").innerHTML= USER_NAME;
document.getElementById("email").innerHTML= USER_EMAIL;


let string = "One punch"+"\n"+
"Sanjou! Hisshou! Shijou saikyou!!"+"\n"+
"Nandattenda? furasutoreshon ore wa tomaranai"+"\n"+
"(One punch) Kanryou! Rensen renshou!"+"\n"+
"Ore wa katsu! Tsune ni katsu! Asshou!"+"\n"+
"Power! Get power! Girigiri genkai made"+"\n"+
"Hero, ore o tataeru koe ya kassai nante hoshiku wa nai sa"+"\n"+
"Hero, dakara hitoshirezu aku to tatakau"+"\n"+
"(Nobody knows who he is)"+"\n"+
"Sora ooi oshiyoseru teki ore wa se o muke wa shinai"+"\n"+
"Hero, naraba yurugi naki kakugo shita tame kuridase tekken"+"\n"+
"Hero"+"\n"+
"Kodoku na, hero";
const synth = window.speechSynthesis;
const utterThis = new SpeechSynthesisUtterance(string);
utterThis.rate=1;
utterThis.pitch = 0;


window.addEventListener('load', () => {
      utterThis.voice = synth.getVoices()[0];
		synth.speak(utterThis);
    });

window.addEventListener('unload', () => {
      synth.cancel();
    });