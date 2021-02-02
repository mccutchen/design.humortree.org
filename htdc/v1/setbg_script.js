var colors = new Array("00","33","66","99","cc","ff");
		
function makecolor()
{
	var colorString = "#";
	
	var trr = colors[Math.floor(Math.random() * colors.length)];
	var tgg = colors[Math.floor(Math.random() * colors.length)];
	var tbb = colors[Math.floor(Math.random() * colors.length)];
	
	colorString = colorString + trr + tgg + tbb;				
	return colorString;
}

function setbg()
{
	document.bgColor = makecolor();
}

function swap(state)
{
	if(state != 0)
		document.images[0].src = "images/" + state + ".gif";
	else if(!state)
		setTimeout("document.images[0].src = 'images/blank.gif';",100);
}