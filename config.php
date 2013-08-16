<?php

/* directory containing the posts (may contain subdirectories) */
$articles_dir = "posts";

/* date format displayed when showing a post */
$date_format = "F j, Y";

/* numbers of columns for the posts (if <0, no limit is set) */
$cols = 80;

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
