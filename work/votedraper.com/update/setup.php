<?php
// HTpost 3.0 beta 1
// setup.php

require_once ("HTpost-settings.php");
require_once ("HTpost-functions.php");
$date = date("F j, Y");

if (!isset ($HTTP_POST_VARS["action"])) $HTTP_POST_VARS["action"] = "setup";
//if (!isset ($HTTP_POST_VARS["username"])) header ("Location: HTpost.php");

if (!isset ($HTpost_settings["first_run"])) {
	if (!checkLogin ($HTTP_POST_VARS["username"], $HTTP_SERVER_VARS["REMOTE_ADDR"])) header ("Location: HTpost.php?errno=2");
}
elseif (isset ($HTpost_settings["first_run"])) {
	$HTTP_POST_VARS["username"] = "New User";
	$HTTP_POST_VARS["email"] = "no email";
}


////////////////////////////////////////////
// Setup                                    
////////////////////////////////////////////
if ($HTTP_POST_VARS["action"] == "setup") {
?>


<html>
<head>
	<title>Setup - HTpost 3.0 beta 1</title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container" style="width:550px;">

	<div class="header setup">
		<h3>* Setup</h3>
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
		<form action="setup.php" method="POST">
		<table border="0" cellpadding="5" cellspacing="0">
		<?php if (isset ($HTpost_settings["first_run"])) {
		?>
		<tr>
			<td class="setupHeadBG" colspan="2" valign="middle">
				<h1 class="setupHead">New User</h1>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="font-size:11px;" valign="top">
				It appears to us that this is your first time to
				try to use HTpost.  If that is the case, we would
				like you to configure HTpost before you get to 
				use it.
				<br>
				<br>
				The following long form will let you set up almost
				every facet of HTpost, but it can be tricky to fill
				out correctly.
				<br>
				<br>
				To make sure that you do fill it out correctly, we
				would ask you to <strong>please read the file "readme.html"
				included with HTpost.</strong>  That should make the following
				form easier to understand.
				<br>
				<br>
				<br>
				
			</td>
		</tr>
		<?php
		}
		?>
		
		<!-- ---------------------------------------------------------- -->
		<!-- GENERAL OPTIONS ------------------------------------------ -->
		<!-- ---------------------------------------------------------- -->
		<tr>
			<td class="setupHeadBG" colspan="2" valign="middle">
				<h1 class="setupHead">General Settings</h1>
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Display Cutoff</h4><br>
				This is the number of posts that HTpost will
				display at once on your main news/web log page.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput" name="display_cutoff" value="<?php echo $HTpost_settings["display_cutoff"] ?>" size="3" maxlength="2"> posts
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Session Timeout</h4><br>
				This is the maximum number of minutes a user can
				be logged in before being required to re-log in.
				(If you take a long time to type posts, you may want
				to make this number fairly large.)
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput" name="session_timeout" value="<?php echo $HTpost_settings["display_cutoff"] ?>" size="3" maxlength="3"> minutes
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Output to XML?</h4><br>
				This option tells HTpost to create an XML file
				that contains the newest posts that you've made.
				This sort of XML file is most commonly used if you
				want to syndicate your posts, to let people from
				other web sites pick up the file and parse it.
			</td>
			<td class="setupOption" valign="middle">
				<input type="radio" name="output_xml" value="true" <?php if ($HTpost_settings["output_xml"] == "true") echo "checked" ?>> yes
				<br>
				<input type="radio" name="output_xml" value="false" <?php if ($HTpost_settings["output_xml"] == "false") echo "checked" ?>> no
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Segregate Posts by Days?</h4><br>
				This option tells HTpost to display all the posts from
				a single day under a header for that day.  (You will
				need to modify the "daily header" HTML below.)
			</td>
			<td class="setupOption" valign="middle">
				<input type="radio" name="daily_header" value="true" <?php if ($HTpost_settings["daily_header"] == "true") echo "checked" ?>> yes
				<br>
				<input type="radio" name="daily_header" value="false" <?php if ($HTpost_settings["daily_header"] == "false") echo "checked" ?>> no
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Daily Header</h4><br>
				Type (or copy in) the HTML that you want to
				be displayed at the top of each day's posts.
				Make sure you include <strong>{{daily_header}}</strong>
				exactly where you want HTpost to insert each day's date.
			</td>
			<td class="setupOption" valign="middle">
				<textarea class="generalInput setupText" name="daily_header_template"><?php echo $HTpost_settings["daily_header_template"] ?></textarea>
			</td>
		</tr>
		
		
		
		<!-- ---------------------------------------------------------- -->
		<!-- PATH SETTINGS -------------------------------------------- -->
		<!-- ---------------------------------------------------------- -->
		<tr>
			<td class="setupHeadBG" colspan="2" valign="middle">
				<h1 class="setupHead">Path Settings</h1>
				<br><br>
				<strong>* Note:</strong> Paths can be pretty tricky. If you're the least
				bit confused, please consult the <strong>Readme.html</strong> file that
				was included with HTpost.
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Path to Main Page</h4><br>
				This is the relative path to the page that HTpost
				will be updating.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="path_main" value="<?php echo $HTpost_settings["path_main"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Main Template Path</h4><br>
				This is the path to the template that HTpost should
				use to determine how your posts fit into your
				main page.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="path_main_template" value="<?php echo $HTpost_settings["path_main_template"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Post Template Path</h4><br>
				This is the relative path to the template that HTpost
				should use when displaying your posts.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="path_template" value="<?php echo $HTpost_settings["path_template"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">XML Output Path</h4><br>
				This is the relative path to the file that you want
				HTpost to write XML to (if you've enabled that option).
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="path_xml_output" value="<?php echo $HTpost_settings["path_xml_output"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">XML Template Path</h4><br>
				This is the relative path to the template that you
				want HTpost to use when creating your XML file (again,
				if you've enabled that option).
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="path_xml_template" value="<?php echo $HTpost_settings["path_xml_template"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Redirect URL</h4><br>
				This is the URL (either absolute or relative) that
				you want HTpost to send you to after you've created
				or edited a post.  (Usually the same as the path to
				the main page.)
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="redirect_url" value="<?php echo $HTpost_settings["redirect_url"] ?>">
			</td>
		</tr>
		
		
		
		
		<!-- ---------------------------------------------------------- -->
		<!-- DATE/TIME ------------------------------------------------ -->
		<!-- ---------------------------------------------------------- -->
		<tr>
			<td class="setupHeadBG" colspan="2" valign="middle">
				<h1 class="setupHead">Date/Time Settings</h1>
				<br><br>
				<strong>* Note:</strong> You <strong>must</strong> read the 
				documentation included with HTpost to know how to set these
				values.  Consult the docs/date.html file.
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Date Format for Individual Posts</h4><br>
				The format of the date for each individual post.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" name="date_individual" class="generalInput inputWidthA" value="<?php echo $HTpost_settings["date_individual"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Time Format for Individual Posts</h4><br>
				The format of the time for each individual post.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" name="time_individual" class="generalInput inputWidthA" value="<?php echo $HTpost_settings["time_individual"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Date Format for Daily Divisions</h4><br>
				The format of the date for the header of each day, if you've
				chosen to segregate your posts by day.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" name="date_daily" class="generalInput inputWidthA" value="<?php echo $HTpost_settings["date_daily"] ?>">
			</td>
		</tr>
		
		
		
		
		
		
		<!-- ---------------------------------------------------------- -->
		<!-- DATABASE SETTINGS ---------------------------------------- -->
		<!-- ---------------------------------------------------------- -->
		<tr>
			<td class="setupHeadBG" colspan="2" valign="middle">
				<h1 class="setupHead">Database Settings</h1>
				<br><br>
				<strong>* Note:</strong> This information can be obtained
				from your hosts if you do not already know it.  It should not
				be changed once you have set up HTpost.
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Hostname</h4><br>
				The name of the server that your database
				management system is on.  Almost always "localhost."
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="DB_hostname" value="<?php echo $HTpost_settings["DB_hostname"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Username</h4><br>
				The username with which you log into your
				database management system.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="DB_username" value="<?php echo $HTpost_settings["DB_username"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Password</h4><br>
				The password required to log into your
				database management system.
			</td>
			<td class="setupOption" valign="middle">
				<input type="password" class="generalInput inputWidthA" name="DB_password" value="<?php echo $HTpost_settings["DB_password"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Database Name</h4><br>
				The name of the database to store HTpost
				information in.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="DB_database" value="<?php echo $HTpost_settings["DB_database"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">"Posts" Table Name</h4><br>
				The name of the database table that you want the
				posts that you make to be stored in.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="DB_post_table" value="<?php echo $HTpost_settings["DB_post_table"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">"Security" Table Name</h4><br>
				The name of the database table that you want the
				security information for HTpost to be stored in.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="DB_security_table" value="<?php echo $HTpost_settings["DB_security_table"] ?>">
			</td>
		</tr>
		
		
		
		<!-- ---------------------------------------------------------- -->
		<!-- ADMIN SETTINGS ------------------------------------------- -->
		<!-- ---------------------------------------------------------- -->
		<tr>
			<td class="setupHeadBG" colspan="2" valign="middle">
				<h1 class="setupHead">Administrator Settings</h1>
				<br><br>
				<strong>* Note:</strong> The user account you set up
				here should be your primary user account.  Accounts
				with administrator privileges can add and delete users,
				while non-administrator accounts can only add, delete and edit
				their own posts.
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Username</h4><br>
				The username for your primary account.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="admin_name" value="<?php echo $HTpost_settings["admin_name"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Password</h4><br>
				The password for your primary account
			</td>
			<td class="setupOption" valign="middle">
				<input type="password" class="generalInput inputWidthA" name="admin_password" value="<?php echo $HTpost_settings["admin_password"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Email Address</h4><br>
				The email address of your primary account.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="admin_email" value="<?php echo $HTpost_settings["admin_email"] ?>">
			</td>
		</tr>
		<tr>
			<td class="setupDescription" valign="top">
				<h4 class="setupHead">Image</h4><br>
				The path to the image you want to associate with this
				account.
			</td>
			<td class="setupOption" valign="middle">
				<input type="text" class="generalInput inputWidthA" name="admin_image" value="<?php echo $HTpost_settings["admin_image"] ?>">
			</td>
		</tr>
		
		
		<tr>
			<td colspan="2">
				<br><input type="submit" class="generalButton inputWidthB" value="Save Settings">
			</td>
		</tr>
		
		</table>
		<input type="hidden" name="HTpost_version" value="<?php echo $HTpost_settings["HTpost_version"] ?>">
		<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
		<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
		<input type="hidden" name="action" value="save">
		</form>
	</div>
<!-- ---------------------------------------------------- -->
<!-- end COMPOSE section -------------------------------- -->
<!-- ---------------------------------------------------- -->

</div>
</body>
</html>
<?php
}








////////////////////////////////////////////
// Save                                     
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "save") {
	$str =
	"<?php\n"
	."// HTpost 3.0 beta 1\n"
	."// HTpost-settings.php\n"
	."// *** DO NOT edit this file manually. Log in to HTpost, go to Administrative Options, and choose Setup HTpost.\n\n";

	while (list ($key, $val) = each ($HTTP_POST_VARS)) {
		if ($key != "action" && $key != "username")
			$str .= "\$HTpost_settings[\"$key\"] = \"$val\";\n";
	}
	$str .= "\n?>";
	
	$fp = fopen ("HTpost-settings.php", "w");
	$wr = fwrite ($fp, $str);
	fclose ($fp);
	
	include ("HTpost-settings.php");
	$r = testDb ();
?>



<html>
<head>
	<title>Setup - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">
	<div class="header setup">
		<h3>* Setup</h3>
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
		<?php if ($wr != -1) {?>Your settings were saved successfully.  Hopefully you haven't screwed things up.<?}
					else {?>Your settings were not saved successfully.  See what you can do to fix that.<?}?>
		<br>
		<br>
		<?php
			if (!$r) {
		?>
			
			<strong>* Note:</strong>  The settings that you have just saved for your database
			don't seem to be working.  There could be a couple of reasons for this.
			<ol style="list-style-type:lower-alpha;">
				<li>
					This is your first time to use HTpost, and you have just given me your database
					information for the first time.  If this is the case, answer <strong>'YES'</strong> to the question
					below to initialize your database for use with HTpost.<br><br>
				</li>
				<li>
					You have decided to change the name of the tables that HTpost uses to store your
					posts in your database.  If you have decided this, keep in mind that all of your
					old posts will no longer be accessible by HTpost.  You will be starting fresh.  If
					this is what you want, answer <strong>'YES'</strong> to the question below to initialize
					new tables for HTpost to use.<br><br>
				</li>
				<li>
					If neither of these situations applies to you, answer <strong>'NO'</strong> to the
					question below to return to Setup and correct any mistakes that you have made.
				</li>
			</ol>
			<br>
			<br>
			Do you want me to initialize your database with the settings you provided?<br>
			<form action="setup.php" method="POST">
				<input type="submit" class="generalButton inputWidthA" value="Yes">
				<input type="hidden" name="action" value="initialize">
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"]?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"]?>">
			</form>
			<form action="setup.php" method="POST">
				<input type="submit" class="generalButton inputWidthA" value="No">
				<input type="hidden" name="action" value="setup">
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"]?>">
				<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"]?>">
			</form>
		<?php	
			}
		?>
	</div>
</div>
</body>
</html>
<?
}
















////////////////////////////////////////////
// Initialize                               
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "initialize") {
	$post_table_query = 
		"CREATE TABLE " . $HTpost_settings["DB_post_table"] . " (
			pid INT (5) ZEROFILL NOT NULL auto_increment,
			author VARCHAR (20) NOT NULL,
			email VARCHAR (50),
			title VARCHAR (50),
			date VARCHAR (20),
			category VARCHAR (50),
			post LONGBLOB,
			icon VARCHAR (50),
			PRIMARY KEY (pid)
		)";
	
	$security_table_query = 
		"CREATE TABLE " . $HTpost_settings["DB_security_table"] . " (
			username VARCHAR (50) NOT NULL,
			password VARCHAR (50) NOT NULL,
			email VARCHAR (50) NOT NULL,
			admin VARCHAR (5) NOT NULL,
			image VARCHAR (50),
			login CHAR (16),
			ip VARCHAR (20),
			PRIMARY KEY (username)
		)";
	
	$post_drop = "DROP TABLE IF EXISTS " . $HTpost_settings["DB_post_table"] . "";
	$security_drop = "DROP TABLE IF EXISTS " . $HTpost_settings["DB_security_table"] . "";
	
	dbConnect ();
	
	// drop any existing tables
	mysql_query ($post_drop);
	mysql_query ($security_drop);
	
	// create the tables
	$post = mysql_query ($post_table_query);
	$security = mysql_query ($security_table_query);
	
	$admin_query = 
		"INSERT INTO " . $HTpost_settings["DB_security_table"] . " (
			username, password, email, admin, image, login, ip) VALUES (
			'" . $HTpost_settings["admin_name"] . "','" . $HTpost_settings["admin_password"] . "','" . $HTpost_settings["admin_email"] . "','true','0','0','0'
		)";
	
	// add the first user - the administrator
	$admin = mysql_query ($admin_query);	
?>



<html>
<head>
	<title>Setup - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">
	<div class="header setup">
		<h3>* Setup</h3>
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
		<?php 
			if ($post) echo "The \"Posts\" table was set up successfully.<br><br>";
			else echo "<strong>* Error:</strong> The \"Posts\" table was not set up successfully.<br><br>";
		?>
		<br><br>
		<?php 
			if ($security) echo "The \"Security\" table was set up successfully.<br><br>";
			else echo "<strong>* Error:</strong> The \"Security\" table was not set up successfully.<br><br>";
		?>
		<br><br>
		<?php
			if ($admin) {
				echo "The administrator (main) account has been set up like so:
							<br><strong>Username:</strong> " . $HTpost_settings["admin_name"] .
							"<br><strong>Password:</strong> " . $HTpost_settings["admin_password"] . "<br><br>";
			}
			else echo "<strong>* Error:</strong> The administrator (main) account has not been set up.<br><br>";
		?>
		If you received any error messages above, you should go back and check the database settings you
		gave me.
	</div>
</div>
</body>
</html>
<?
}
?>



