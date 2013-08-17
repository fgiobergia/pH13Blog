<?php

/* your site's name (will be appended to the title of each page) */
$site_name = "pH13Blog";

/* directory containing the posts (may contain subdirectories) */
$articles_dir = "posts";

/* date format displayed when showing a post */
$date_format = "F j, Y";

/* number of columns for the posts (if <0, no limit is set) */
$cols = 80;

/* number of posts to be shown in the index (0=all) */
$show_last = 5;

/* 
   structure of the page: edit this
   howeveryou want, just keep in mind
   that TITLE and body will be replaced
   later
*/
$page = "<html>\n".
        "<head>\n".
        "<title>\n".
        "TITLE".
        "</title>\n".
        "<link rel='stylesheet' type='text/css' href='style.css'>".
        "</head>\n".
        "<body>\n".
        "BODY".
        "</body>\n".
        "</html>\n";

?>
