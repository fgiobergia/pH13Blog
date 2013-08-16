<?php

/* not much, gen_span () was only created to keep the code tidier */
function gen_span ($color) {
	return "<span style = 'color: {$color}'>";
}

/* checks whether $char is alphanumeric or an underscore ("_") */
function is_al_git ($char) {
	$n = ord ($char);
	return (($n>=48 && $n<=57) || ($n>=65 && $n<=90) || ($n>=97 && $n<=122) || ($n==95));
}

/* similar to htmlentities(), but only replaces <&> */
function replace_special ($string) {
	return str_replace ("<","&lt;",str_replace(">","&gt;",str_replace("&","&amp;",$string)));
}

/* performs a scandir () excluding . and .. from the results */
function _scandir ($dir) {
	return array_diff (scandir ($dir,1),array("..","."));
}

?>
