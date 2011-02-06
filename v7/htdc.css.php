<?php
	header ("content-type: text/css");
	$browser = $HTTP_USER_AGENT;
	$css = true;
	
	if ( (eregi ("msie",$browser) && eregi ("[56]", $browser)) || eregi ("gecko",$browser) || eregi ("jigsaw",$browser))
		$css = true;
	else
		$css = false;
	
	if ($css)
	{
?>
BODY {
	background-color: #eee;
	color: #666;
	margin: 0px;
	padding: 0px;
	font: 11px tahoma,verdana, arial, sans-serif;
}
#logo {
	height: 100px;
	background-image: url("img/background.jpg");
	background-repeat: no-repeat;
	background-position: 640px 0px;
	padding: 0px;
	margin: 0px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}
#bottom {
	height: 25px;
	background-image: url("img/bottom.jpg");
	background-repeat: no-repeat;
	padding: 0px;
	margin: 0px;
}
DIV.section {
	padding: 20px;
	padding-left: 40px;
	margin: 0px;
}
DIV.container {
	width: 600px;
}
DIV.block {
	padding: 20px 40px;
}
#about {
	background-color: #eee;
	color: #999;
	border-bottom: 1px solid #ccc;
}
#process {
	background-color: #ddd;
	color: #888;
	border-bottom: 1px solid #bbb;
}
#skills {
	background-color: #ccc;
	color: #777;
	border-bottom: 1px solid #aaa;
}
#current {
	background-color: #bbb;
	color: #666;
	border-bottom: 1px solid #999;
}
#clients {
	background-color: #aaa;
	color: #555;
	border-bottom: 1px solid #888;
}
#colophon {
	background-color: #999;
	color: #444;
	border-bottom: 1px solid #777;
}
H3 {
	font-size: 10px;
	font-weight: bold;
	margin-left: -20px;
	margin-top: 0px;
}
OL {
	list-style-type: lower-alpha;
}
UL {
	list-style-image: url("img/li-666.gif");
}
A:link, A:visited {
	color: #36c;
	background-color: transparent;
	text-decoration: none;
}
A:hover, A:active {
	color: #fff;
	background-color: #36c;
	text-decoration: none;
}
STRONG {
	font-size: 10px;
}
<?php
	}
?>