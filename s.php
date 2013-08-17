<?php
/* main script */
error_reporting (E_ALL ^ E_NOTICE);

header('Content-type: text/html; charset=utf-8'); 

include "config.php";
include "utils.php";
include "highlight.php";
include "tags.php";

$id = join(array_keys($_GET));
if (!preg_match ("|^[0-9]{1,}$|",$id)) {
	die ("Wrong parameter :-(");
}

$dirs = _scandir ($articles_dir);

for ($i=0;$i<count($dirs);$i++) {
	$dir=$dirs[$i];
	if (is_dir ("{$articles_dir}/{$dir}")) {
		$sd = _scandir ("{$articles_dir }/{$dir}");
		if (!empty ($sd)) {
			$dirs = array_merge ($dirs, explode ("|","{$dir}/".join ("|{$dir}/",$sd)));
		}
	}
	else {
		if (preg_match("|{$id}\.txt$|",$dir)) {
			$data = file_get_contents ("{$articles_dir}/{$dir}");
			if (empty ($data)) {
				die ("Summat wrong here :-/");
			}
			list ($title,$timestamp,$content) = explode ("\n",$data,3);
			$title .= " ~ {$site_name}";
			$body = "<pre>\n".
			        "<span style = 'font-size: 18px;'><b>{$title}</b></span>\n\n\n".
			        "<i>Published on ".date($date_format)."</i>\n\n".
			        do_stuff ($content).
			        "</pre>";
			$page = str_replace ("TITLE",$title,str_replace ("BODY",$body,$page));
			echo $page;
		}
	}
}

?>
