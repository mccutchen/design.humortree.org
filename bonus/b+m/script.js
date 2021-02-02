var colors = new Array("#888888","#888888","#9999cc","#ffcc99","#ff99cc","#999900","#0066cc","#cc0000","#ff9900","#000000")

function init()
{
	if(parent.left)
		document.bgColor = parent.left.document.bgColor;
		
	else if(parent.main.left)
		document.bgColor = parent.main.left.document.bgColor;
}

function changeColor(color)
{
	document.bgColor = color;
	parent.main.right.document.bgColor = color;
	parent.main.left.document.bgColor = color;
	event.srcElement.blur();
}