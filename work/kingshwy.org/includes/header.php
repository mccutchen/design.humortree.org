<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<?php
    require_once("base.php");
    $sub_channel_page = (CHANNEL != CURRENT_PAGE);
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title><?php echo isset($title) ? $title : get_channel_title(); ?> &#8212; Kings Highway Conservation District</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/css/kingshwy.css" />
        <?php
            if (file_exists("_extrahead.php")) {
                include_once("_extrahead.php");
            }
        ?>
    </head>

    <body>

        <div id="header">
            <h1>
                <a<?php if(CURRENT_PAGE != "index") { ?> href="/"<?php } ?>>Kings Highway Conservation District</a>
            </h1>

            <a class="skip-nav" href="#content-start">Skip Navigation</a>
            <?php require("navigation.php"); ?>
            <hr />

            <a name="content-start" id="content-start"></a>
            <h2 id="channel-title"><?php echo get_channel_title(); ?></h2>
	    <!--<h2><?php echo CHANNEL . " =&gt; " . CURRENT_PAGE; ?></h2>-->

            <?php if($sub_channel_page) { ?>
                <div id="breadcrumbs">
                    <a href="/">Home</a>&nbsp;&nbsp;&raquo;&nbsp;
                    <a href="<?php echo get_channel_link(); ?>"><?php echo get_channel_link_title(); ?></a>&nbsp;&nbsp;&raquo;&nbsp;
                    <a><?php echo $title; ?></a>
                </div>
            <?php } ?>
        </div>

        <div id="content"<?php if(isset($content_class)) { ?> class="<?php echo $content_class ?>" <?php } ?>>
            <?php if($sub_channel_page) { ?>
            <h3><?php echo $title; ?></h3>
            <?php } ?>
