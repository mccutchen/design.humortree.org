<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>PROTO-TYPE FOR H,T,D,C,</title>
	
	<?php

		$rowstrings["ns"] = "20%,10,30,20,30,6,*"; // am uncertain here
		$rowstrings["ie"] = "20%,10,25,20,30,6,*";
		$rowstrings["old"] = "20%,10,25,20,30,6,*"; // am uncertain here
		
		$ua = getenv("HTTP_USER_AGENT");
		
		if( eregi("mozilla/4", $ua) )
			$browser = "ns";
		
		else
			$browser = "old";
			
		if( $browser == "ns" && eregi("msie",$ua) )
			$browser = "ie";
			
		//Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)
		
		//return $rowstrings[$browser];
		
		?>
		
</head>

<!-- frames -->
<frameset  rows="<?php echo $rowstrings[$browser]; ?>" frameborder="NO" framespacing="0" border="0" frameborder="0" border="no">
    <frame name="" src="blank.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		<frame name="" src="10px.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		<frame name="" src="logo.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		<frame name="" src="20px.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		<frame name="" src="buttons.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		<frame name="" src="6px.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
		<frame name="" src="blank.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
</frameset>

</html>
