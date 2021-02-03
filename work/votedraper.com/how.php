<?php 
	include ("header.php");
	printHeader ("How Can I Help?");
?>
				
<table border="0" cellpadding="0" cellspacing="30" align="center" width="100%">
<tr>
	<td align="center" valign="middle" width="50%">
		<h1>How Can I Help?</h1>
		<h1>* * *</h1>
		<p>
			<span class="opener">There are a number</span> of ways for you
			to help out with the campaign.  If you are interested in giving
			us a hand, fill out the form to the right.
		</p>
		<p>
			You need only give us the information that you want to give us,
			but it would be helpful to have at least a name and an email
			address or phone number, so that we can get back in touch with
			you.  Rest assured, any information you give us will stay with
			us.
		</p>
		<h1>* * *</h1>
	</td>
	<td width="2" background="img/content.divider.gif"><img src="img/spacer.gif" alt="" width="2" height="300"></td>
	<td align="left" valign="middle">
	
	<div id="formContainer">
		<form name="f" action="help.php" method="POST">
		Name:<br>
		<input name="name" type="text" class="inputText"><br><br>
		
		Email Address:<br>
		<input name="email" type="text" class="inputText"><br><br>
		
		Phone Number:<br>
		<input name="number" type="text" class="inputText"><br><br>
		
		What I'll Do (optional):<br>
		<select name="job" class="inputText">
			<option value="not sure">I'm not sure</option>
			<option value="display sign">Display yard sign</option>
			<option value="phone bank">Work phone bank</option>
			<option value="knock on doors">Knock on doors</option>
			<option value="monetary contribution">Make a monetary contribution</option>
			<option value="clerical assistant">Be a clerical assistant</option>
			<option value="give testimonial">Give a testimonial statement</option>
		</select><br><br>
		
		Any questions or other information:<br>
		<textarea name="other" class="inputText textArea" rows="10" cols="20"></textarea><br><br>
		
		<input type="submit" value="Submit information" class="inputText">
		
		</form>
	</div>
		
	</td>
</tr>
</table>
				
			


<?php
	include ("footer.php");
	printFooter ();
?>