<?php
// HTpost 3.0 beta 1
// HTpost.php

require_once ("HTpost-settings.php");
require_once ("HTpost-functions.php");

if (isset ($HTpost_settings["first_run"])) header ("Location: setup.php");

if (!isset ($HTTP_POST_VARS["action"])) $HTTP_POST_VARS["action"] = "login";
$date = date("F j, Y");



////////////////////////////////////////////
// Log In                                   
////////////////////////////////////////////
if ($HTTP_POST_VARS["action"] == "login") {
?>
<html>
<head>
	<title>Log In - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body onload="document.f.username.focus();">
<div class="container">
	<div class="header <?php echo $HTTP_POST_VARS["action"] ?>">
		<h3>* Log In</h3>
	</div>
			<!-- ---------------------------------------------------- -->
			<!-- INFO section (logged in as...) --------------------- -->
			<!-- ---------------------------------------------------- -->
			<div class="grayBar">
				<div class="floatLeft">System: <strong>HTpost <?php echo $HTpost_settings["HTpost_version"] ?></strong></div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<form name="f" action="HTpost.php" method="POST">
		<div class="floatLeft">
			User Name<br>
			<input type="text" name="username" class="generalInput loginInput"><br>
		</div>
		<div class="floatLeft">
			Password<br>
			<input type="password" name="password" class="generalInput loginInput"><br>
		</div>
		
		<div class="clearLeft">
			<input type="submit" value="Log in" class="generalButton">
		</div>
		<input type="hidden" name="action" value="compose">
		</form>
	</div>
<!-- ---------------------------------------------------- -->
<!-- end COMPOSE section -------------------------------- -->
<!-- ---------------------------------------------------- -->

<?php if (isset ($HTTP_GET_VARS["errno"])) {
?>
<!-- ---------------------------------------------------- -->
<!-- ERROR section                  --------------------- -->
<!-- ---------------------------------------------------- -->
	<div class="grayBar">
		<strong>* Error:</strong> <?php echo HTpost_error ($HTTP_GET_VARS["errno"]) ?>
	</div>
<!-- ---------------------------------------------------- -->
<!-- ---------------------------------------------------- -->
<?php
}
?>
</div>
</body>
</html>
<?php
}







////////////////////////////////////////////
// Compose                                  
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "compose") {
	if ($email = doLogin ($HTTP_POST_VARS["username"], $HTTP_POST_VARS["password"], $HTTP_SERVER_VARS["REMOTE_ADDR"])) {
?>
<html>
<head>
	<title>Compose - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<script type="text/javascript">
	</script>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body onload="document.f.title.focus();">
<div class="container">
<!-- ---------------------------------------------------- -->
<!-- COMPOSE section ------------------------------------ -->
<!-- ---------------------------------------------------- -->
	<div class="header <?php echo $HTTP_POST_VARS["action"] ?>">
		<h3>* Compose</h3>
	</div>
			<!-- ---------------------------------------------------- -->
			<!-- INFO section (logged in as...) --------------------- -->
			<!-- ---------------------------------------------------- -->
			<div class="grayBar">
				<div class="floatLeft">Logged in as: <strong><?php echo $HTTP_POST_VARS["username"] ?></strong> (<?php echo $email ?>)</div>
				<div class="floatRight"><?php echo $date ?></div>
				&nbsp;
			</div>
			<!-- ---------------------------------------------------- -->
			<!-- ---------------------------------------------------- -->
	<div class="containerMain">
		<form name="f" action="HTpost.php" method="POST">
		<div class="floatLeft">
			Title / Headline<br>
			<input type="text" name="title" class="generalInput inputWidthA"><br><br>
			Category<br>
			<input type="text" name="category" class="generalInput inputWidthA"><br>
			<?php
				if ($arr = getUnique ("category")) {
			?>
			<select name="category_select" class="generalInput inputWidthA" style="margin-top:0px;">
				<option value="">(stored categories)</option>
			<?php
					foreach ($arr as $cat) {
			?>
				<option value="<?php echo $cat ?>"><?php echo $cat ?></option>
			<?php		
					}
				}
			?>
			</select><br><br>
			Icon<br>
			<input type="text" name="icon" class="generalInput inputWidthA"><br>
			<?php
				if ($arr = getUnique ("icon")) {
			?>
			<select name="icon_select" class="generalInput inputWidthA" style="margin-top:0px;">
				<option value="">(stored icons)</option>
			<?php
					foreach ($arr as $cat) {
			?>
				<option value="<?php echo $cat ?>"><?php echo $cat ?></option>
			<?php		
					}
				}
			?>
			</select><br><br>
		</div>
		<div class="floatRight">
			Post Text<br>
			<textarea name="post" rows="10" cols="30" class="generalInput"></textarea>
		</div>
		<div class="clearLeft"><input type="submit" value="Submit Post" class="generalButton inputWidthB"></div>
		<input type="hidden" name="action" value="post">
		<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
		<input type="hidden" name="email" value="<?php echo $email ?>">
		</form>
	</div>
<!-- ---------------------------------------------------- -->
<!-- end COMPOSE section -------------------------------- -->
<!-- ---------------------------------------------------- -->

	<div class="grayBar">
		<div class="floatLeft">
			<form action="HTpost.php" method="POST">
				<?php echo getEditList () ?>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $email ?>">
				<input type="hidden" name="action" value="edit">
				<input type="submit" value="Edit Post" class="generalButton">
			</form>
		</div>
		<div class="floatRight">
			<form action="admin.php" method="POST">
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $email ?>">
				<input type="submit" value="Administrative Options" class="generalButton">
			</form>
		</div>
		&nbsp;<br>&nbsp;
	</div>
</div>
</body>
</html>
<?php
	}
	else
		header ("location:HTpost.php?errno=1");
}










////////////////////////////////////////////
// Post                                     
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "post") {
	if (checkLogin ($HTTP_POST_VARS["username"], $HTTP_SERVER_VARS["REMOTE_ADDR"])) {
		
		$post_array["author"] = $HTTP_POST_VARS["username"];
		$post_array["email"] = $HTTP_POST_VARS["email"];
		$post_array["title"] = pre_db_text ($HTTP_POST_VARS["title"]);
		$post_array["date"] = getTimestamp ();
		$post_array["category"] = isset ($HTTP_POST_VARS["category_select"]) ? pre_db_text ($HTTP_POST_VARS["category_select"]) : pre_db_text ($HTTP_POST_VARS["category"]);
		$post_array["post"] = pre_db_text ($HTTP_POST_VARS["post"]);
		$post_array["icon"] = isset ($HTTP_POST_VARS["icon_select"]) ? pre_db_text ($HTTP_POST_VARS["icon_select"]) : pre_db_text ($HTTP_POST_VARS["icon"]);
		
		insertPost ($post_array);
		build ();
	}
}





////////////////////////////////////////////
// Commit                                   
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "commit") {
	if (checkLogin ($HTTP_POST_VARS["username"], $HTTP_SERVER_VARS["REMOTE_ADDR"])) {
		
		$post_array["author"] = $HTTP_POST_VARS["username"];
		$post_array["email"] = $HTTP_POST_VARS["email"];
		$post_array["title"] = pre_db_text ($HTTP_POST_VARS["title"]);
		$post_array["category"] = pre_db_text ($HTTP_POST_VARS["category"]);
		$post_array["post"] = pre_db_text ($HTTP_POST_VARS["post"]);
		$post_array["icon"] = $HTTP_POST_VARS["icon"];
		
		updatePost ($HTTP_POST_VARS["pid"], $post_array);
		build ();
	}
}

////////////////////////////////////////////
// Delete                                   
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "delete") {
	if (checkLogin ($HTTP_POST_VARS["username"], $HTTP_SERVER_VARS["REMOTE_ADDR"])) {
		deletePost ($HTTP_POST_VARS["pid"]);
		build ();
	}
}






////////////////////////////////////////////
// Edit                                     
////////////////////////////////////////////
elseif ($HTTP_POST_VARS["action"] == "edit") {
	if (checkLogin ($HTTP_POST_VARS["username"], $HTTP_SERVER_VARS["REMOTE_ADDR"])) {
?>
<html>
<head>
	<title>Edit - HTpost <?php echo $HTpost_settings["HTpost_version"] ?></title>
	<link rel="stylesheet" type="text/css" href="HTpost.css">
</head>
<body>
<div class="container">
<!-- ---------------------------------------------------- -->
<!-- COMPOSE section ------------------------------------ -->
<!-- ---------------------------------------------------- -->
	<div class="header edit">
		<h3>* Edit</h3>
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
		$sql = "select * from " . $HTpost_settings["DB_post_table"] . " where pid = " . $HTTP_POST_VARS["post_id"];
		dbConnect ();
		$r = mysql_query ($sql);
		if ($row = mysql_fetch_array ($r)) {
?>
		<form name="f" action="HTpost.php" method="POST">
		<div class="floatLeft">
			Title / Headline<br>
			<input type="text" name="title" class="generalInput inputWidthA" value="<?php echo $row["title"] ?>"><br><br>
			Category<br>
			<input type="text" name="category" class="generalInput inputWidthA" value="<?php echo $row["category"] ?>"><br><br>
			Icon<br>
			<input type="text" name="icon" class="generalInput inputWidthA" value="<?php echo $row["icon"] ?>"><br>
		</div>
		<div class="floatRight">
			Post Text<br>
			<textarea name="post" rows="10" cols="30" class="generalInput"><?php echo str_replace ("<br />","\n",$row["post"]) ?></textarea>
		</div>
		<div class="clearLeft"><input type="submit" value="Save Changes" class="generalButton inputWidthB"></div>
		<input type="hidden" name="action" value="commit">
		<input type="hidden" name="pid" value="<?php echo $HTTP_POST_VARS["post_id"] ?>">
		<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
		<input type="hidden" name="email" value="<?php echo $HTTP_POST_VARS["email"] ?>">
		</form>
<?php
		}
		else {
?>
		I'm sorry, but I didn't find any posts that match the Post ID (<strong><?php echo $HTTP_POST_VARS["post_id"] ?></strong>) that you supplied.  Please try again.
<?php
		}
?>
	</div>
<!-- ---------------------------------------------------- -->
<!-- end COMPOSE section -------------------------------- -->
<!-- ---------------------------------------------------- -->

	<div class="grayBar">
		<div class="floatLeft">
			<form action="HTpost.php" method="POST">
				<?php echo getEditList () ?>
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="email" value="<?php echo $email ?>">
				<input type="hidden" name="action" value="edit">
				<input type="submit" value="Edit Post" class="generalButton">
			</form>
		</div>
		<div class="floatRight">
			<form action="HTpost.php" method="POST">
				<input type="hidden" name="username" value="<?php echo $HTTP_POST_VARS["username"] ?>">
				<input type="hidden" name="pid" value="<?php echo $HTTP_POST_VARS["post_id"] ?>">
				<input type="hidden" name="action" value="delete">
				<input type="submit" value="Delete This Post" class="generalButton">
			</form>
		</div>
		&nbsp;<br>&nbsp;
	</div>
</div>
</body>
</html>
<?php
	}
	else
		header ("location:HTpost.php?errno=1");
}

?>