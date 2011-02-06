<!-- no !DOCTYPE because this site needs to show up well in Netscape 4, and to make  -->
<!-- it do that and still show up well in Netscape 6 and IE 5(mac) and 6(win) i have -->
<!-- to turn off the DTD.  Netscape can rot in hell for all i care.                  -->

<html>
<head>
	<title>HTDC version 4.0 beta 3</title>
	
	<link rel="stylesheet" type="text/css" href="htdc.css">
	
	<script type="text/javascript">
		function swap(which,state)
		{
			var ext = (state) ? "_on.jpg" : "_off.jpg";
			document.images[which].src = "img/nav_" + which + ext;
		}
	</script>
	
	<meta http-equiv= "pragma" CONTENT="no-cache">
	<meta name="ROBOTS" content="ALL">
	<meta name="DESCRIPTION" content="">
	<meta name="KEYWORDS" content="">
	<meta name="AUTHOR" content="will mccutchen - will@humortree.org">
	
</head>

<body bgcolor="#666666">

<table border="0" align="center" cellpadding="0" cellspacing="0" height="100%">
<tr>
<td height="100%" valign="middle" align="center">








<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td align="left" colspan="2"><img src="img/logo.jpg" alt="The Humor Tree Design Coalition"></td>
</tr>
<tr>
	<td height="5" colspan="2"><!-- a spacer TD tag --></td>
<tr>
	<td align="left" width="280" bgcolor="white" class="bodytext">
	<!-- content of the page goes here -->
					
<?php
	if (!isset($section))
	{
  
?>
		<!-- if there is no section defined, display a splash -->
		<table border="0" cellpadding="0" cellspacing="7" width="100%">
		<tr>
			<td><img src="img/splashes/<?php echo rand(1,6) ?>.jpg" alt="a beautiful splash image" height="300" width="500"></td>
		</tr>
		</table>
    <!-- end splash image -->
  </td>
<?php
	}
	else
	{
		$sectionIncludePath = "includes/$section.php";
    $sidebarIncludePath = "includes/$section.sidebar.php";
		include ($sectionIncludePath);
?>
		
	<!-- content stops here -->
	</td>
  <td width="220" valign="top" bgcolor="#cccccc">
  <!-- sidebar goes here -->
    <?php include ($sidebarIncludePath) ?>
  <!-- sidebar ends here -->
  </td>
<?php
  }
?>
</tr>
<tr>
	<td align="right" colspan="2">
	<!-- navigation goes here -->
	
		<table border="0" cellpadding="0" cellspacing="7" align="right">
		<tr>
			<td><a href="?section=us" onmouseover="swap('us',true);" onmouseout="swap('us',false);"><img name="us" src="img/nav_us_off.jpg" border="0" alt="Us."></a></td>
			<td width="5"></td>
			<td><a href="javascript:void(null);" onmouseover="swap('work',true);" onmouseout="swap('work',false);"><img name="work" src="img/nav_work_off.jpg" border="0" alt="Us."></a></td>
			<td width="5"></td>
			<td><a href="javascript:void(null);" onmouseover="swap('play',true);" onmouseout="swap('play',false);"><img name="play" src="img/nav_play_off.jpg" border="0" alt="Us."></a></td>
		</tr>
		</table>
	
	<!-- navigation stops here -->
	</td>
</tr>
</table>










</td>
</tr>
</table>
</body>
</html>
