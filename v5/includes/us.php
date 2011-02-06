<?php 
	if (isset($subsection))
		$subsectionIncludePath = "includes/$section.$subsection.php";
?>
		<table border="0" cellpadding="0" cellspacing="7" width="100%">
		<tr>
			<td align="left" valign="top" height="20"><img src="img/header_<?php echo $section ?>.jpg" alt="Us."></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="bodyText">
<?php
	if (isset($subsectionIncludePath))
		include($subsectionIncludePath);
	
	else
	{
?>
			<br>
				&nbsp;&nbsp;The Humor Tree Design Coalition (HTDC) is a group of
				young men who are out to change the world.  We are
				talented and dynamic.  We are always learning new things
				and looking at old things in new ways.
				<br>
				<br>
				&nbsp;&nbsp;The HTDC looks at each project as a problem.  We know
				there is a solution, and our job is to find it.
				<br>
				<br>
				&nbsp;&nbsp;We are a problem soliving organization. We love
				the chance to be creative, to do things differently.
				
<?php
	}
?>
			</td>
		</tr>
		</table>
