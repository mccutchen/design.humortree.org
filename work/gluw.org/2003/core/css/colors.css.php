<?php
// define your colors here

$colors["green"] = Array("#669933","#99CC66","#CCFF99"); // darkest to lightest
$colors["orange"] = Array("#993300","#CC6600","#FF9933"); // darkest to lightest
$colors["blue"] = Array("#006699","#3399CC","#66CCFF"); // darkest to lightest

$colors["green"] = Array("#336633","#669966","#99CC99"); // darkest to lightest
$colors["orange"] = Array("#993300","#CC6600","#FF9933"); // darkest to lightest
$colors["blue"] = Array("#006699","#3399CC","#99CCFF"); // darkest to lightest


$template = "
/*

{0}  Darkest
{1}
{2}
{3}  Lightest

*/

body.WhoWeAre { background-color: " . $colors["green"][2] . " !important; }
body.WhoWeAre div#content h1 { color: " . $colors["green"][0] . " !important; }
body.WhoWeAre div#content h3 { color: " . $colors["green"][0] . " !important; }
body.WhoWeAre div#document {
	border-top-color: " . $colors["green"][0] . " !important;
	border-bottom-color: " . $colors["green"][0] . " !important;
}


body.WhatWeDo { background-color: " . $colors["orange"][2] . " !important; }
body.WhatWeDo div#content h1 { color: " . $colors["orange"][0] . " !important; }
body.WhatWeDo div#content h3 { color: " . $colors["orange"][0] . " !important; }
body.WhatWeDo div#document { 
	border-top-color: " . $colors["orange"][0] . " !important;
	border-bottom-color: " . $colors["orange"][0] . " !important;
}


body.LearnMore { background-color: " . $colors["blue"][2] . " !important; }
body.LearnMore div#content h1 { color: " . $colors["blue"][0] . " !important; }
body.LearnMore div#content h3 { color: " . $colors["blue"][0] . " !important; }
body.LearnMore div#document {
	border-top-color: " . $colors["blue"][0] . " !important;
	border-bottom-color: " . $colors["blue"][0] . " !important;
}


/* Navigation colors */
div#nav ul li.WhoWeAre { color: " . $colors["green"][0] . " !important; }
div#nav ul li.WhoWeAre ul { border-left-color: " . $colors["green"][1] . " !important; }
div#nav ul li.WhoWeAre a { color: " . $colors["green"][0] . " !important; }
div#nav ul li.WhoWeAre span { color: " . $colors["green"][2] . " !important; }
div#nav ul li.WhoWeAre a:hover {
	background-color: " . $colors["green"][2] . " !important;
	border-left-color: " . $colors["green"][1] . " !important;
}

div#nav ul li.WhatWeDo { color: " . $colors["orange"][0] . " !important; }
div#nav ul li.WhatWeDo ul { border-left-color: " . $colors["orange"][1] . " !important; }
div#nav ul li.WhatWeDo a { color: " . $colors["orange"][0] . " !important; }
div#nav ul li.WhatWeDo span { color: " . $colors["orange"][2] . " !important; }
div#nav ul li.WhatWeDo a:hover {
	background-color: " . $colors["orange"][2] . " !important;
	border-left-color: " . $colors["orange"][1] . " !important;
}

div#nav ul li.LearnMore { color: " . $colors["blue"][0] . " !important; }
div#nav ul li.LearnMore ul { border-left-color: " . $colors["blue"][1] . " !important; }
div#nav ul li.LearnMore a { color: " . $colors["blue"][0] . " !important; }
div#nav ul li.LearnMore span { color: " . $colors["blue"][2] . " !important; }
div#nav ul li.LearnMore a:hover {
	background-color: " . $colors["blue"][2] . " !important;
	border-left-color: " . $colors["blue"][1] . " !important;
}

";


$filename = 'colors.css';
$file = fopen($filename, 'w');
fwrite($file, $template);
fclose($file);
