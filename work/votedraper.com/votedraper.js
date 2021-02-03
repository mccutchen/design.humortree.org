function preload () {
	var imageNames = new Array ("news","issues","proven","how","about","calender");
	var images = new Array ();
	for (var i = 0; i < imageNames.length; i++) {
		var temp = new Image ();
		temp.src = "img/nav." + imageNames[i] + "-on.gif";
	}
}

function swap (name) {
	var im = document.images[name];
	if (im.src.indexOf ("off") != -1) {
		im.src = "img/nav." + name + "-on.gif";
	}
	else if (im.src.indexOf ("on") != -1) {
		im.src = "img/nav." + name + "-off.gif";
	}
}