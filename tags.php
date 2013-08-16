<?php

/* this performs a conversion from code to tags.
   If you need to add new tags, and said tags requrire 
   spaces in them, replace the spaces with underscores,
   then edit do_stuff () (i.e. add a line similar to
   $e[0] = str_replace ("<img_src","<img src",$e[0]);
   (this is because _wraptext () would have been harder
   to write if tags contained spaces)
*/
function convert_tags ($string) {
	$tags = array (
	       "[b]"=>"<b>",
	       "[/b]"=>"</b>",
	       "[i]"=>"<i>",
	       "[/i]"=>"</i>"
	);
	foreach ($tags as $code => $tag) {
		$string=str_replace ($code,$tag,$string);
	}
	$string=preg_replace ("|\[img (.*?)\](.*?)\[/img\]|","<img_src='$1'>$2</img>",$string);
	$string=preg_replace ("|\[url (.*?)\](.*?)\[/url\]|","<a_href='$1'>$2</a>",$string);
	return $string;
}

/* similar to wraptext, but I had to
   rewrite it because I needed a function
   that ignored html tags when wrapping
*/
function _wraptext ($text) {
	$i=0;
	$w="";
	global $cols;
	if ($cols<0) {
		return $text;
	}
	$lns = explode (chr(0xff),$text);
	foreach ($lns as $ln) {
		$c=0;
		$wds = explode (" ",$ln);
		foreach ($wds as $wd) {
			preg_match_all ("|(<.*?>)|",$wd,$p);
			$tlen = mb_strlen(join("",$p[1]),"utf-8");
			if ($c+mb_strlen($wd,"utf-8")-$tlen<=$cols) {
				$w .= $wd.(($c+mb_strlen($wd,"utf-8")+1-$tlen==$cols)?"":" ");
				$c += mb_strlen($wd,"utf-8")+1-$tlen;
			}
			else {
				$w .= chr(0xff)."{$wd} ";
				$c = mb_strlen($wd,"utf-8")+1-$tlen;
			}
		}
		$w .= chr(0xff);
	}
	return $w;
}

/* does stuff */
function do_stuff ($string) {
	$string = replace_special(str_replace ("\n",chr(0xff),$string));
	$ec = explode ("[/code]",$string);
	$out = "";
	foreach ($ec as $c) {
		$e = explode ("[code",$c,2);
		$e[0] = _wraptext (convert_tags ($e[0]));
		$e[0] = str_replace ("<img_src","<img src",$e[0]);
		$e[0] = str_replace ("<a_href","<a href",$e[0]);
		if (!empty ($e[1])) {
			preg_match ("|^(.*?)\](.*?)$|",$e[1],$m);
			$m[2] = highlight (str_replace(chr(0xff),"\n",$m[2]),($m[1][0]==' ')?substr($m[1],1):$m[1]);
			$out .= "{$e[0]}<div class='code'>{$m[2]}</div>";
		}
		else {
			$out .= $e[0];
		}
	}
	return str_replace (chr(0xff),"\n",$out);
}

?>
