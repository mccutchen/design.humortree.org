<?php

$textsize["ns"] = "12px"; 
$textsize["ie"] = "11px";

$ua = getenv("HTTP_USER_AGENT");

if( eregi("mozilla/4", $ua) )
	$browser = "ns";
	
else if(eregi("mozilla/5", $ua) )
	$browser = "ie";

if( $browser == "ns" && eregi("msie",$ua) )
	$browser = "ie";
	
//Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)
?>
.text
{
	font:<?php echo $textsize[$browser]?> arial;
	color:#999999;
}

a:link
{
	color:#666666;
	text-decoration:none;
}

a:visited
{
	color:#444444;
	text-decoration:none;
}

a:hover, a:active
{
	color:black;
	text-decoration:underline;
}