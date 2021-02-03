<?php
// HTpost 3.0 beta 1
// setup.php

require_once ("HTpost-settings.php");
require_once ("HTpost-functions.php");
$date = date("F j, Y");

if (!isset ($HTTP_POST_VARS["action"])) $HTTP_POST_VARS["action"] = "admin";
if (!isset ($HTTP_POST_VARS["username"])) header ("Location: HTpost.php");

if (!checkLogin ($HTTP_POST_VARS["username"], $HTTP_SERVER_VARS["REMOTE_ADDR"], true)) header ("Location: HTpost.php?errno=5");



////////////////////////////////////////////
// Admin                                    
////////////////////////////////////////////
if ($HTTP_POST_VARS["action"] == "admin") {
?>


<html>
<head>
	<title>Admin - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">

	<div class="header admin">
		<h3>* Admin</h3>
	</div>
			<!-- ---------------------------------------------------- -->
			<!-- INFO section (logged in as...) --------------------- -->
			<!-- ---------------------------------------------------- -->
			<div class="grayBar">
				<div class="floatLeft">Logged in as: <strong><?php echo $HTTP_POST_VARS["username"] ?></strong> (<?php echo $HTTP_POST_VARS["email"] ?>)</div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<div class="floatLeft">
			<form action="admin.php" method="POST">
				Edit a User:<br>
				<select name="edit_username" class="generalInput inputWidthD">
					<option value="">(username)</option>
					<?php
						dbConnect ();
						$sql = "select username from security";
						$r = mysql_query ($sql);
						if ($row = mysql_fetch_array ($r)) {
							do {
								echo "<option value=\"" . $row["username"] . "\">" . $row["username"] . "</option>\n";
							} while ($row = mysql_fetch_array ($r));
						}
					?>
				</select><br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="edit">
				<input type="submit" value="Edit" class="generalButton inputWidthD">
			</form>
			<br>
			<br>
			<div class="inputWidthD">
				Use the form to the right to add new users
				to HTpost.  You have to supply a new username
				(that is unique) and a new password at the
				least.
				<br><br>
				<strong>* Note:</strong> If you give a user
				administrative options, that user can then
				add other users and edit the HTpost setup, so
				be careful.
			</div>
		</div>
		<div class="floatRight">
			<form action="admin.php" method="POST">
				<strong>Add a user:</strong><br><br>
				Username:<br>
				<input type="text" name="new_username" class="generalInput inputWidthD">
				<br>
				Password:<br>
				<input type="text" name="new_password" class="generalInput inputWidthD">
				<br>
				Email Address:<br>
				<input type="text" name="new_email" class="generalInput inputWidthD">
				<br>
				Image:<br>
				<input type="text" name="new_image" class="generalInput inputWidthD">
				<br>
				Administrator?<br>
				<input type="radio" name="new_admin" value="false" checked> no &nbsp;&nbsp;&nbsp;<input type="radio" name="new_admin" value="true"> yes
				<br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="add">
				<input type="submit" value="Add User" class="generalButton inputWidthD">
			</form>
		</div>
		<div class="clearLeft">&nbsp;</div>
	</div>
<!-- ---------------------------------------------------- -->
<!-- end COMPOSE section -------------------------------- -->
<!-- ---------------------------------------------------- -->
	
	<div class="grayBar">
		<form action="setup.php" method="POST">
			<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
			<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
			<input type="submit" value="Setup HTpost" class="generalButton inputWidthB">
		</form>
	</div>
	
</div>
</body>
</html>
<?php
}








////////////////////////////////////////////
// Add                                      
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "add") {
	?>
<html>
<head>
	<title>Admin - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">
	<div class="header admin">
		<h3>* Admin</h3>
	</div>
			<!-- ---------------------------------------------------- -->
			<!-- INFO section (logged in as...) --------------------- -->
			<!-- ---------------------------------------------------- -->
			<div class="grayBar">
				<div class="floatLeft">Logged in as: <strong><?php echo $HTTP_POST_VARS["username"] ?></strong> (<?php echo $HTTP_POST_VARS["email"] ?>)</div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<div class="floatLeft">
			<form action="admin.php" method="POST">
				Edit a User:<br>
				<select name="edit_username" class="generalInput inputWidthD">
					<option value="">(username)</option>
					<?php
					
						dbConnect ();
						$sql = "select username from " . $HTpost_settings["DB_security_table"] . " where username = '" . $HTTP_POST_VARS["new_username"] . "'";
						$num = mysql_query ($sql);
						$num = mysql_num_rows ($num);
						if ($num < 1) {
							$sql = "insert into " . $HTpost_settings["DB_security_table"] . " (username, password, email, admin, image)
										values ('" . $HTTP_POST_VARS["new_username"] . "', '" . $HTTP_POST_VARS["new_password"] . "', '" . $HTTP_POST_VARS["new_email"] . "', '" . $HTTP_POST_VARS["new_admin"] . "', '" . $HTTP_POST_VARS["new_image"] . "')";
							$r = mysql_query ($sql);
							$good = true;
						}
						else $good = false;
					
						$sql = "select username from security";
						$r = mysql_query ($sql);
						if ($row = mysql_fetch_array ($r)) {
							do {
								echo "<option value=\"" . $row["username"] . "\">" . $row["username"] . "</option>\n";
							} while ($row = mysql_fetch_array ($r));
						}
						dbClose ();
					?>
				</select><br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="edit">
				<input type="submit" value="Edit" class="generalButton inputWidthD">
			</form>
			<br>
			<br>
			<div class="inputWidthD">
			<?php
				if ($good) {
			?>
				We think that you have just successfully added
				the the following user.<br>
				<br>
				<strong>Username:</strong> <?php echo $HTTP_POST_VARS["new_username"] ?><br>
				<strong>Password:</strong> <?php echo $HTTP_POST_VARS["new_password"] ?><br>
				<strong>Email Address:</strong> <?php echo $HTTP_POST_VARS["new_email"] ?><br>
				<strong>Administrator?</strong> <?php echo $HTTP_POST_VARS["new_admin"] ?><br>
				<strong>Image:</strong> <?php echo $HTTP_POST_VARS["new_image"] ?><br>
				<br>
				Check and see if this user is now in the drop-down box above, or try
				to log in as this user to make sure that everything worked properly.
			<?php
				}
				elseif (!$good) {
			?>
				There is already a user with that name registered to use HTpost.  You can
				either pick a different username, or edit or delete the user that already
				has that name.
			<?php
				}
			?>
			</div>
		</div>
		<div class="floatRight">
			<form action="admin.php" method="POST">
				<strong>Add a user:</strong><br><br>
				Username:<br>
				<input type="text" name="new_username" class="generalInput inputWidthD">
				<br>
				Password:<br>
				<input type="text" name="new_password" class="generalInput inputWidthD">
				<br>
				Email Address:<br>
				<input type="text" name="new_email" class="generalInput inputWidthD">
				<br>
				Image:<br>
				<input type="text" name="new_image" class="generalInput inputWidthD">
				<br>
				Administrator?<br>
				<input type="radio" name="new_admin" value="false" checked> no &nbsp;&nbsp;&nbsp;<input type="radio" name="new_admin" value="true"> yes
				<br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="add">
				<input type="submit" value="Add User" class="generalButton inputWidthD">
			</form>
		</div>
		<div class="clearLeft">&nbsp;</div>
	</div>
	
	<div class="grayBar">
		<form action="setup.php" method="POST">
			<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
			<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
			<input type="submit" value="Setup HTpost" class="generalButton inputWidthB">
		</form>
	</div>
	
</div>
</body>
</html>
<?
}









////////////////////////////////////////////
// Edit                                     
////////////////////////////////////////////
if ($HTTP_POST_VARS["action"] == "edit") {
	dbConnect ();
	$sql = "select username, password, email, admin, image from " . $HTpost_settings["DB_security_table"] . " where username = '" . $HTTP_POST_VARS["edit_username"] . "'";
	$r = mysql_query ($sql);
	$row = mysql_fetch_array ($r);
	dbClose ();
?>
<html>
<head>
	<title>Admin - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">

	<div class="header admin">
		<h3>* Admin</h3>
	</div>
			<!-- ---------------------------------------------------- -->
			<!-- INFO section (logged in as...) --------------------- -->
			<!-- ---------------------------------------------------- -->
			<div class="grayBar">
				<div class="floatLeft">Logged in as: <strong><?php echo $HTTP_POST_VARS["username"] ?></strong> (<?php echo $HTTP_POST_VARS["email"] ?>)</div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<div class="floatLeft">
			<form action="admin.php" method="POST">
				<strong>Edit a User:</strong><br><br>
				Username:<br>
				<input type="text" name="new_username" class="generalInput inputWidthD" value="<?php echo $row["username"] ?>">
				<br>
				Password:<br>
				<input type="text" name="new_password" class="generalInput inputWidthD" value="<?php echo $row["password"] ?>">
				<br>
				Email Address:<br>
				<input type="text" name="new_email" class="generalInput inputWidthD" value="<?php echo $row["email"] ?>">
				<br>
				Image:<br>
				<input type="text" name="new_image" class="generalInput inputWidthD" value="<?php echo $row["image"] ?>">
				<br>
				Administrator?<br>
				<input type="radio" name="new_admin" value="false"<?php if ($row["admin"] == "false") echo ' checked';?>> no &nbsp;&nbsp;&nbsp;<input type="radio" name="new_admin" value="true"<?php if ($row["admin"] == "true") echo 'checked';?>> yes
				<br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="commit">
				<input type="submit" value="Save Settings" class="generalButton inputWidthD">
			</form>
			
		</div>
		<div class="floatRight">
			<div class="inputWidthD">
			<form action="admin.php" method="POST">
				Use the form to the left to edit the user <?php echo $HTTP_POST_VARS["edit_username"] ?>.
				Remember that if you give the user administrative priviledges, he or she can then add
				users on their own, and have access to the HTpost settings, which means that they could
				really screw things up.  Be wary.
				<br>
				<br>
				If you would like to delete <?php echo $HTTP_POST_VARS["edit_username"] ?>,
				click on the button below:
				<br>
				<input type="submit" value="Delete <?php echo $HTTP_POST_VARS["edit_username"] ?>" class="generalButton inputWidthD">
				<input type="hidden" name="delete_username" value="<?php echo $HTTP_POST_VARS["edit_username"] ?>">
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="delete">
				
			</form>
			</div>
		</div>
		<div class="clearLeft">&nbsp;</div>
	</div>
	
	<div class="grayBar">
		<form action="setup.php" method="POST">
			<input type="hidden" name="username" value="jacob">
			<input type="hidden" name="email" value="jacob@horcob.org">
			<input type="submit" value="Setup HTpost" class="generalButton inputWidthB">
		</form>
	</div>
	
</div>
</body>
</html>
<?php
}











////////////////////////////////////////////
// Commit                                   
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "commit") {
	dbConnect ();
	$sql = "update " . $HTpost_settings["DB_security_table"] . " set
					username = '" . $HTTP_POST_VARS["new_username"] . "',
					password = '" . $HTTP_POST_VARS["new_password"] . "',
					email = '" . $HTTP_POST_VARS["new_email"] . "',
					admin = '" . $HTTP_POST_VARS["new_admin"] . "',
					image = '" . $HTTP_POST_VARS["new_username"] . "'
					where username = '" . $HTTP_POST_VARS["new_username"] . "'";
	$r = mysql_query ($sql);
	?>
<html>
<head>
	<title>Admin - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">
	<div class="header admin">
		<h3>* Admin</h3>
	</div>
			<div class="grayBar">
				<div class="floatLeft">Logged in as: <strong><?php echo $HTTP_POST_VARS["username"] ?></strong> (<?php echo $HTTP_POST_VARS["email"] ?>)</div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<div class="floatLeft">
			<form action="admin.php" method="POST">
				Edit a User:<br>
				<select name="edit_username" class="generalInput inputWidthD">
					<option value="">(username)</option>
					<?php
						$sql = "select username from security";
						$r = mysql_query ($sql);
						if ($row = mysql_fetch_array ($r)) {
							do {
								echo "<option value=\"" . $row["username"] . "\">" . $row["username"] . "</option>\n";
							} while ($row = mysql_fetch_array ($r));
						}
						dbClose ();
					?>
				</select><br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="edit">
				<input type="submit" value="Edit" class="generalButton inputWidthD">
			</form>
			<br>
			<br>
			<div class="inputWidthD">
				We think that you have just successfully updated the following user:<br>
				<br>
				<strong>New Username:</strong> <?php echo $HTTP_POST_VARS["new_username"] ?><br>
				<strong>New Password:</strong> <?php echo $HTTP_POST_VARS["new_password"] ?><br>
				<strong>New Email Address:</strong> <?php echo $HTTP_POST_VARS["new_email"] ?><br>
				<strong>New Administrator?</strong> <?php echo $HTTP_POST_VARS["new_admin"] ?><br>
				<strong>New Image:</strong> <?php echo $HTTP_POST_VARS["new_image"] ?><br>
				<br>
			</div>
		</div>
		<div class="floatRight">
			<form action="admin.php" method="POST">
				<strong>Add a user:</strong><br><br>
				Username:<br>
				<input type="text" name="new_username" class="generalInput inputWidthD">
				<br>
				Password:<br>
				<input type="text" name="new_password" class="generalInput inputWidthD">
				<br>
				Email Address:<br>
				<input type="text" name="new_email" class="generalInput inputWidthD">
				<br>
				Image:<br>
				<input type="text" name="new_image" class="generalInput inputWidthD">
				<br>
				Administrator?<br>
				<input type="radio" name="new_admin" value="false" checked> no &nbsp;&nbsp;&nbsp;<input type="radio" name="new_admin" value="true"> yes
				<br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="add">
				<input type="submit" value="Add User" class="generalButton inputWidthD">
			</form>
		</div>
		<div class="clearLeft">&nbsp;</div>
	</div>
	
	<div class="grayBar">
		<form action="setup.php" method="POST">
			<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
			<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
			<input type="submit" value="Setup HTpost" class="generalButton inputWidthB">
		</form>
	</div>
	
</div>
</body>
</html>
<?
}











////////////////////////////////////////////
// Delete                                   
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "delete") {
	dbConnect ();
	$sql = "delete from " . $HTpost_settings["DB_security_table"] . " where username = '" . $HTTP_POST_VARS["delete_username"] . "'";
	$r = mysql_query ($sql);
	?>
<html>
<head>
	<title>Admin - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">
	<div class="header admin">
		<h3>* Admin</h3>
	</div>
			<!-- ---------------------------------------------------- -->
			<!-- INFO section (logged in as...) --------------------- -->
			<!-- ---------------------------------------------------- -->
			<div class="grayBar">
				<div class="floatLeft">Logged in as: <strong><?php echo $HTTP_POST_VARS["username"] ?></strong> (<?php echo $HTTP_POST_VARS["email"] ?>)</div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<div class="floatLeft">
			<form action="admin.php" method="POST">
				Edit a User:<br>
				<select name="edit_username" class="generalInput inputWidthD">
					<option value="">(username)</option>
					<?php
						$sql = "select username from security";
						$r = mysql_query ($sql);
						if ($row = mysql_fetch_array ($r)) {
							do {
								echo "<option value=\"" . $row["username"] . "\">" . $row["username"] . "</option>\n";
							} while ($row = mysql_fetch_array ($r));
						}
						dbClose ();
					?>
				</select><br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="edit">
				<input type="submit" value="Edit" class="generalButton inputWidthD">
			</form>
			<br>
			<br>
			<div class="inputWidthD">
				We think that you have just successfully 
				deleted <?php echo $HTTP_POST_VARS["delete_username"] ?>.  Please
				see if he or she is still listed in the
				drop-down box above.<br>
				<br>
			</div>
		</div>
		<div class="floatRight">
			<form action="admin.php" method="POST">
				<strong>Add a user:</strong><br><br>
				Username:<br>
				<input type="text" name="new_username" class="generalInput inputWidthD">
				<br>
				Password:<br>
				<input type="text" name="new_password" class="generalInput inputWidthD">
				<br>
				Email Address:<br>
				<input type="text" name="new_email" class="generalInput inputWidthD">
				<br>
				Image:<br>
				<input type="text" name="new_image" class="generalInput inputWidthD">
				<br>
				Administrator?<br>
				<input type="radio" name="new_admin" value="false" checked> no &nbsp;&nbsp;&nbsp;<input type="radio" name="new_admin" value="true"> yes
				<br>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
				<input type="hidden" name="action" value="add">
				<input type="submit" value="Add User" class="generalButton inputWidthD">
			</form>
		</div>
		<div class="clearLeft">&nbsp;</div>
	</div>
	
	<div class="grayBar">
		<form action="setup.php" method="POST">
			<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
			<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
			<input type="submit" value="Setup HTpost" class="generalButton inputWidthB">
		</form>
	</div>
	
</div>
</body>
</html>
<?
}





?>