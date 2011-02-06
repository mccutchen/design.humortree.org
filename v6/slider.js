var FOCUSED = main = openBio = null;
var Z = 0;
var sliders = new Array ();
var hilite_temp;
var GOAL = 0;
var SPEED = 0;
var accelerateBy = 1;
var decelerateBy = 1;
var MAXSPEED = 5;
var delay = 10;


function init ()
{
	HT_init();
	sliders["main"] = new slider ('main','main');
	sliders["about"] = new slider ('about','main');
	sliders["ourskills"] = new slider ('ourskills','main');
	sliders["clientlist"] = new slider ('clientlist','main');
	sliders["contact"] = new slider ('contact','main');
	sliders["colophon"] = new slider ('colophon','main');
	focusSlider ("main");
	
	document.onmousemove = move;
	window.setInterval ("update();",delay);
}

function focusSlider (name)
{
	Z++;
	if (FOCUSED)
	{
		FOCUSED.focused = false;
		FOCUSED.capture = false;
		blurSlider (FOCUSED.id);
	}
	
	document.images[name + "_image"].src = "img/" + name + ".gif";
	document.getElementById (name + "_white").style.backgroundColor = "white";
	
	FOCUSED = sliders[name];
	FOCUSED.focused = true;
	FOCUSED.capture = true;
	FOCUSED.style.zIndex = Z;
	FOCUSED.style.visibility = "visible";
	return true;
}

function closeSlider (name)
{
	Z--;
	sliders[name].style.visibility = "hidden";
	sliders[name].style.zIndex = 0;
	sliders[name].focused = false;
	sliders[name].capture = false;
	focusSlider (sliders[name].parent);
}


function slider (id,parent)
{
	this.id = id;
	this.style = HT_getStyleObject (this.id);
	this.focused = false;
	this.offset = 0;
	this.capture = false;
	this.parent = parent;
	this.moving = false;
	this.direction = "";
	this.speed = 0;
	this.a = .5;
	this.d = .5;
	this.maxspeed = 10;
}

function startCapture ()
{
	FOCUSED.capture = true;
}
function endCapture ()
{
	FOCUSED.capture = false;
}

function move (e)
{
	if (findMouse (e))
	{
		if(isIE && FOCUSED.capture)
		{
			GOAL = event.clientX - FOCUSED.offset;
		}
		else if(isNS6 && FOCUSED.capture)
		{
			GOAL = e.pageX - FOCUSED.offset;
		}
		return true;
	}
	else
	{
		GOAL = false;
		return true;
	}
}

function update ()
{	
	var diff = 0;
	if (FOCUSED.capture && GOAL)
	{
		if (FOCUSED.direction == -1)
		{
			if (parseInt (FOCUSED.style.left) <= GOAL)
				return false;
			
			diff = parseInt (FOCUSED.style.left) - GOAL;
		}
		
		if (FOCUSED.direction == 1)
		{
			if (parseInt (FOCUSED.style.left) >= GOAL)
				return false;
			
			diff = GOAL - parseInt (FOCUSED.style.left);
		}
		
		// speed = (1/100)(x^2)
		var speed = .001 * sq (diff);
		
				
		if (speed > FOCUSED.maxspeed)
			speed = FOCUSED.maxspeed;
		else if (diff <= 32)
			speed = 1;
		else if (speed < 1)
			speed = 0;
				
		FOCUSED.speed = speed;
					
		HT_moveTo (FOCUSED.id, parseInt (FOCUSED.style.left) + FOCUSED.speed * FOCUSED.direction, 0);
	}
	else
		return false;
}

function sq (i)
{
	return i * i;
}

function findMouse (e)
{
	var eventLeft;
	
	focusedLeft = parseInt (FOCUSED.style.left);
	focusedRight = focusedLeft + parseInt (FOCUSED.style.width);
	
	if (isIE)
		eventLeft = event.clientX;
	else if (isNS6)
		eventLeft = e.pageX;
		
	if (eventLeft >= focusedLeft && eventLeft <= focusedRight)
	{
		endCapture();
		return false;
	}
		
	else
	{
		if (eventLeft <= focusedLeft)
		{	
			FOCUSED.direction = -1;
			FOCUSED.offset = 0;
		}
		else if (eventLeft >= focusedLeft)
		{
			FOCUSED.direction = 1;
			FOCUSED.offset = parseInt (FOCUSED.style.width);
		}
			
		startCapture();
		return true;
	}
}

function hilite (which, state)
{
	if (state)
	{
		hilite_temp = which.parentNode.style.backgroundColor;
		which.parentNode.style.backgroundColor = "#cccccc";
	}
	else if (!state)
		which.parentNode.style.backgroundColor = hilite_temp;
}

function blurSlider (which)
{
	document.images["" + which + "_image"].src = "img/" + which + "_shadow.gif";
	document.getElementById (which + "_white").style.backgroundColor = "#cccccc";
}

function showBio (name)
{
	state = HT_getStyleObject(name).display;
	var head = HT_getStyleObject (name + "_head");
	var plus = HT_getObject (name + "_plus");
				
	if (state == "none")
	{
		HT_show (name,"d");
		head.backgroundColor = hilite_temp = "#cccccc";
		plus.innerHTML = "&ndash; ";
		if (openBio != null)
			hideBio (openBio);
		openBio = name;
	}
	else
	{
		openBio = null;
		head.backgroundColor = hilite_temp = "transparent";
		hideBio (name);
	}
}

function hideBio (name)
{
	var head = HT_getStyleObject (name + "_head");
	head.backgroundColor = "transparent";
	var plus = HT_getObject (name + "_plus");
	plus.innerHTML = "+ ";
	//alert (head.backgroundColor);
	HT_hide (name,"d");
}