<?php
// HTpost 3.0 beta 1
// HTpost-functions.php

require_once ("HTpost-settings.php");


////////////////////////////////////////////
// Utility functions                        
////////////////////////////////////////////
// for connecting to and disconnecting from 
// the database defined in the settings.    
function dbConnect () {
	global $HTpost_settings;
	
	mysql_connect ($HTpost_settings["DB_hostname"], $HTpost_settings["DB_username"], $HTpost_settings["DB_password"]);
	mysql_select_db ($HTpost_settings["DB_database"]);
}
function dbClose () {
	mysql_close ();
}
function testDb () {
	global $HTpost_settings;
	$c = mysql_connect ($HTpost_settings["DB_hostname"], $HTpost_settings["DB_username"], $HTpost_settings["DB_password"]);
	$d = mysql_select_db ($HTpost_settings["DB_database"]);
	$p = mysql_query ("select date from " . $HTpost_settings["DB_post_table"]);
	$s = mysql_query ("select username from " . $HTpost_settings["DB_security_table"]);
	if (!$c || !$d || !$p || !$s)
		return false;
	else
		return true;
}




////////////////////////////////////////////
// Authentication functions                 
////////////////////////////////////////////
// for checking usernames and passwords,    
// logging users into HTpost, and making    
// sure that their login is still valid     

// doLogin
// returns user's email address if login works
// returns false if login fails
function doLogin ($username, $password, $ip) {
	global $HTpost_settings;
	
	dbConnect ();
	$q = "SELECT password, email FROM " . $HTpost_settings["DB_security_table"] . " WHERE username = '$username'";
	$r = mysql_query ($q);
	if ($r = mysql_fetch_array ($r)) {
		if ($r["password"] == $password) {
			$e = $r["email"];
			$now = date ("Y-m-d H:i");
			$touch = "UPDATE " . $HTpost_settings["DB_security_table"] . " SET login='$now;', ip='$ip'";
			$r = mysql_query ($touch);
			if ($r) return $e;
			else return false;
		}
		else return false;
	}
	else
		return false;
}

function checkLogin ($username, $ip, $admin = false) {
	global $HTpost_settings;
	
	dbConnect ();
	$q = "SELECT login, ip, admin FROM " . $HTpost_settings["DB_security_table"] . " WHERE username = '$username'";
	$r = mysql_query ($q);
	if ($r = mysql_fetch_array ($r)) {
		if (checkTime ($r["login"]) && $ip == $r["ip"]) {
			if ($admin && $r["admin"] == "true") return true;
			elseif ($admin && $r["admin"] == "false") return false;
			else return true;
		}
		else return false;
	}
	else return false;
}

function checkTime ($past) {
	global $HTpost_settings;
	
	if (!$past) return false;
	$now = strtotime (date ("Y-m-d H:i"));
	$past = strtotime ($past);
	$d = ($now - $past) / 60;
	//echo $d;
	if ($d < $HTpost_settings["session_timeout"]) return true;
	else return false;
}







function build () {
	global $HTpost_settings;
	
	$post_template = fread (fopen ($HTpost_settings["path_template"], "r"), filesize ($HTpost_settings["path_template"]));
	$posts = "";
	
	$sql = "select * from " . $HTpost_settings["DB_post_table"] . " order by pid desc limit " . $HTpost_settings["display_cutoff"];
	dbConnect ();
	$r = mysql_query ($sql);
	if ($row = mysql_fetch_array ($r)) {
		do {
			$temp = $post_template;
			$temp = str_replace ("<HTpost:date>",date ($HTpost_settings["date_individual"],$row["date"]),$temp);
			$temp = str_replace ("<HTpost:title>",$row["title"],$temp);
			$temp = str_replace ("<HTpost:post>",$row["post"],$temp);
			$temp = str_replace ("<HTpost:pid>",$row["pid"],$temp);
			$posts .= $temp;
		} while ($row = mysql_fetch_array ($r));
	}
	dbClose ();
	
	$main_template = fread (fopen ($HTpost_settings["path_main_template"], "r"), filesize ($HTpost_settings["path_main_template"]));
	$new_main = str_replace ("<HTpost:posts>",$posts,$main_template);
	
	fwrite (fopen ($HTpost_settings["path_main"],"w"), $new_main);
	
	header ("Location:" . $HTpost_settings["redirect_url"]);
}














////////////////////////////////////////////
// Error functions                          
////////////////////////////////////////////
// for turning error numbers into error     
// messages                                 
function HTpost_error ($n) {
	switch ($n) {
		case 1: $e = "Login failed.  Make sure you are spelling your user name and password correctly and try again.";
			break;
		case 2:	$e = "Session timed out.  You were logged in for more than the time allowed.  Please log in again.";
			break;
		case 3: $e = "Nothing to display.  There are no posts in the database right now.";
			break;
		case 4: $e = "No search results.  Please try a different search word or phrase.";
			break;
		case 5: $e = "You lack administrator priviledges.  Use a different account and try again.";
			break;
		default: $e = "Some error occurred.  Cross your fingers and try again.";
			break;
	}
	return $e;
}




////////////////////////////////////////////
// Formatting functions                     
////////////////////////////////////////////
// for making sure text is the correct state
// before entering it into the database.    
function pre_db_text ($text) {
	$text = str_replace ("\n", "<br />", $text);
	return $text;
}
function post_db_text ($text) {
	$text = stripslashes ($text);
	return $text;
}





////////////////////////////////////////////
// Database functions                       
////////////////////////////////////////////
// for inserting and updating information   
// in the database.
function insertPost ($p) {
	global $HTpost_settings;
	
	$cols = array_keys ($p);
	$vals = array_values ($p);
	$q = "INSERT INTO " . $HTpost_settings["DB_post_table"] . " (" . $cols[0];
	for ($i = 1; $i < sizeof ($cols); $i++) {
		$q .= "," . $cols[$i] . "";
	}
	$q .= ") VALUES ('" . $vals[0] . "'";
	for ($i = 1; $i < sizeof ($vals); $i++) {
		$q .= ",'" . $vals[$i] . "'";
	}
	$q .= ")";
	$r = mysql_query ($q) or die ("argh!  no query!");
	//if ($r) echo "worked, i think.";
	//else echo "nope.";
}
function updatePost ($pid, $p) {
	global $HTpost_settings;
	
	// UPDATE tablename SET a=sa, b=sb WHERE pid=pid
	
	$q = "UPDATE " . $HTpost_settings["DB_post_table"] . " SET " . $cols[0];
	while (list ($key, $val) = each ($p)) {
		$q .= "$key='$val',";
	}
	$q = substr_replace ($q, "", strlen ($q) - 1);
	$q .= " WHERE pid='$pid'";
	$r = mysql_query ($q) or die ("argh!  no query!");
}
function deletePost ($pid) {
	global $HTpost_settings;
	
	$q = "DELETE FROM " . $HTpost_settings["DB_post_table"] . " WHERE pid = '$pid'";
	$r = mysql_query ($q) or die ("argh!  no query!");
}


function getUnique ($col_name) {
	global $HTpost_settings;
	
	dbConnect ();
	$q = "SELECT DISTINCT $col_name FROM " . $HTpost_settings["DB_post_table"];
	$r = mysql_query ($q);
	if ($arr = mysql_fetch_row ($r)) {
		do {
			if ($arr[0] != "") $return_arr[] = $arr[0];
		} while ($arr = mysql_fetch_row ($r));
	}
	else $return_arr = false;
	return $return_arr;
}

function getEditList () {
	global $HTpost_settings;
	$s = "<select name=\"post_id\" class=\"darkerInput\">\n";
	$q = "SELECT pid, title FROM " . $HTpost_settings["DB_post_table"] . " ORDER BY pid desc";
	dbConnect ();
	$r = mysql_query ($q);
	if ($arr = mysql_fetch_array ($r)) {
		do {
			$title = substr_replace ($arr["title"], "...", 15, strlen ($arr["title"]));
			$s .= "<option value=\"" . $arr["pid"] . "\">$title</option>\n";
		} while ($arr = mysql_fetch_array ($r));
	}
	$s .= "</select>\n";
	return $s;
}






////////////////////////////////////////////
// Miscellaneous functions                  
////////////////////////////////////////////
// for doing, guess what, miscellaneous     
// things.                                  
function getTimestamp () {
	$year = date ("Y"); $month = date ("m"); $day = date ("d");	$hour = date ("H");	$minute = date ("i");	$second = date ("s");
	return mktime ($hour, $minute, $second, $month, $day, $year);
}
?>