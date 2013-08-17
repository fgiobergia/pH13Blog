<?php

error_reporting (E_ALL ^ E_NOTICE);

header('Content-type: text/html; charset=utf-8');

include "config.php";
include "utils.php";

$dirs = _scandir ($articles_dir);
$d = array ();
$f = array ();
for ($i=0;$i<count($dirs);$i++) {
	$dir=$dirs[$i];
	if (is_dir ("{$articles_dir}/{$dir}")) {
		$sd = _scandir ("{$articles_dir }/{$dir}");
		if (!empty ($sd)) {
			$dirs = array_merge ($dirs, explode ("|","{$dir}/".join ("|{$dir}/",$sd)));
		}
		array_push ($d,"<a href = 'index.php?c=".count($d)."'>".str_replace ("_"," ",pathinfo($dir,PATHINFO_BASENAME))."</a>");
	}
	else {
                if (preg_match("|([0-9]{1,})\.txt$|",$dir,$p)) {
			$data = file_get_contents ("{$articles_dir}/{$dir}");
			if (!empty ($data)) {
				list ($title,$timestamp,$content) = explode ("\n",$data,3);
				$f[$p[1]]="{$timestamp}:".htmlentities($title);
			}
		}
	}
}

if (!isset ($_GET['c'])) {
	arsort ($f);
	$title = $site_name;
	$x = preg_replace ("|Array|","<b>Categories</b>",print_r ($d,true),1);
	$body = "<pre>\n";
	$body .= "<b>Latest posts</b>\n";
	$i=0;
	foreach ($f as $id => $v) {
		$a = explode (":",$v,2);
		$body .= "<a href = 's.php?{$id}'>{$a[1]}</a> published on ".date($date_format,$a[0])."\n";
                if (++$i==$show_last) {
			break;
		}
	}
	$body .= "\n";
	$body .= "{$x}</pre>\n";
}
else {
	$v = intval ($_GET['c']);
	if ($v<count ($d)) {
		preg_match ("|^<a.*?>(.*?)</a>$|",$d[$v],$p);
		$title = htmlentities($p[1])." ~ {$site_name}";
		$body = "<pre>";
		$body .= "<b>".htmlentities($p[1])."</b>\n";
		$body .= "<a href = 'index.php'>Index</a>\n\n";
		foreach ($dirs as $dir) {
			if (preg_match ("|{$p[1]}/([0-9]{1,}).txt$|",$dir,$m)) {
				$c = file_get_contents ("{$articles_dir}/{$dir}");
				if (!empty ($c)) {
					list ($ttl,$timestamp,$post) = explode ("\n",$c,3);
					$body .= "<a href = 's.php?{$m[1]}'>".htmlentities($ttl)."</a> published on ".date($date_format,$timestamp)."\n";
				}
			}
		}
		$body .= "</pre>";
	}
}

$page = str_replace ("TITLE",$title,str_replace("BODY",$body,$page));
echo $page;


?>
