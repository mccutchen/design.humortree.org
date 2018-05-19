<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<head>

<?php

	$rowstrings["ns"] = "*,420,*"; // am uncertain here
	$rowstrings["ie"] = "*,400,*";
	
	$ua = getenv(HTTP_USER_AGENT);
	
	if( eregi("mozilla/4", $ua) )
		$browser = "ns";
	
	else
		$browser = "old";
		
	if( $browser == "ns" && eregi("msie",$ua) || eregi("mozilla/5",$ua))
		$browser = "ie";
		
	//Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)
	
	//return $rowstrings[$browser];
	
	?>

</head>


<frameset  cols="<?php echo $rowstrings[$browser] ?>" frameborder="NO" framespacing="0" border="0" frameborder="0" border="no">
    <frame name="" src="gray.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		
		<frameset rows="100%,*" frameborder="NO" framespacing="0" border="0" frameborder="0" border="no">
			<frame name="" src="main.html" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" noresize>
			<frame name="" src="loader.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		</frameset>
			
    <frame name="" src="gray.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
</frameset>

</html>