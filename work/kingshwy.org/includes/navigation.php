<?php require_once("base.php"); ?>

<ul>
    <?php
        foreach($site_structure as $channel => $link_title) {
            if($channel == CHANNEL) { ?>
    <li><a><?php echo get_channel_link_title($channel); ?></a></li>
            <?php
            } else { ?>
    <li><a href="<?php echo get_channel_link($channel); ?>"><?php echo get_channel_link_title($channel); ?></a></li>
            <?php
            }
        }
    ?>
</ul>
