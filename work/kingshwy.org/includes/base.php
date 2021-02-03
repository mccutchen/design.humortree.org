<?php
    /**************************************************************************
        $site_structure is an array that maps channel paths to channel
        titles.  The key is the path to the channel and the value is either
        the channel title or an array of (link_title, channel_title).
    **************************************************************************/
    $site_structure = array(
        "index" => array("Home", "Welcome to Kings Highway"),
        "about" => array("About", "About Kings Highway"),
        "contacts" => "Contacts",
        "architecture" => "Architecture",
        "directions" => "Directions",
        "events" => "Events",
        "finances" => "Finances",
        "links" => "Links",
        "archives" => "Archives"
    );


    /**************************************************************************
        Get the components of the current path
    **************************************************************************/
    function strip_php_ext($filename) {
        return basename($filename, ".php");
    }

    function get_path_components() {
        /* returns an array of the components of the path to the current
         * PHP script.  For example:
         *     /about.php -> ["about"]
         *     /about/definition.php -> ["about", "definition"]
         */
        $path_components = explode("/", $_SERVER["SCRIPT_NAME"]);

        // remove the first element if it is empty, which takes care of
        // the leading /
        if ($path_components[0] == "") {
            array_shift($path_components);
        }

        // strip the .php extension from any components of the path
        $path_components = array_map("strip_php_ext", $path_components);

        return $path_components;
    }

    $path_components = get_path_components();


    /**************************************************************************
        Constants defined for each page:
            CHANNEL -- the channel of the current page
            CURRENT_PAGE -- the current page
    **************************************************************************/
    define("CHANNEL", $path_components[0]);
    define("CURRENT_PAGE", $path_components[count($path_components) - 1]);


    /**************************************************************************
        Convenience functions for getting channel titles, link titles and
        links.  All of these default to using the current CHANNEL.
    **************************************************************************/
    function get_channel_title($channel = CHANNEL) {
        global $site_structure;
        $title = $site_structure[$channel];
        return is_array($title) ? $title[1] : $title;
    }

    function get_channel_link_title($channel = CHANNEL) {
        global $site_structure;
        $title = $site_structure[$channel];
        return is_array($title) ? $title[0] : $title;
    }

    function get_channel_link($channel = CHANNEL) {
        return ($channel == "index") ? "/" : "/" . $channel . ".php";
    }


    /**************************************************************************
        Try to include _channel.php, if it's available
    **************************************************************************/
    if (file_exists("_channel.php")) {
        include_once("_channel.php");
    }
?>
