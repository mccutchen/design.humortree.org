<?php
	// help.php
	// -- votedraper.org
	
	$to = "ralphdraper@hotmail.com";
	$from = "votedraper.com";
	$subject = "interested in helping";
	
	$name = $HTTP_POST_VARS["name"];
	$email = $HTTP_POST_VARS["email"];
	$number = $HTTP_POST_VARS["number"];
	$job = $HTTP_POST_VARS["job"];
	$other = $HTTP_POST_VARS["other"];
	
	$message = 
		"***  Automatically Generated Information from Votedraper.com ***\n"
		. " (you can just reply to this message to send an email to this person) \n\n\n"
		. "name: $name\n\n"
		. "email: $email\n\n"
		. "phone number: $number\n\n"
		. "i'll do this: $job\n\n"
		. "other information:\n$other\n\n"
		. "*** End of Information.  Now it's up to you to make contact. ***";
		
	mail ($to, $subject, $message, "From: $from\r\n" . "Reply-To: $email\r\n");

?>

<?php 
	include ("header.php");
	printHeader ("Thanks!");
?>




<div class="standalone">
	<h1>Thanks!</h1>
	<h1>* * *</h1>
	<p>
		Thank you for your interest in the campaign.  We will be contacting you
		shortly.
	</p>
</div>




<?php
	include ("footer.php");
	printFooter ();
?>