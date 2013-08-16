<?php

/* Basic syntax highlighter */
/* C and PHP implemented so far */
function highlight ($string, $lang) {
	$lines = explode ("\n",$string);
	$c=0;
	$s=0;
	$out="";
	$grey = "#8A8A8A";
	$red = "#FF0000";
	$keywords = array ();
	$keywords['C'] = array (
	                         "auto","break", "case", "char","const","continue",
	                         "default","do", "double", "else", "enum","extern",
	                         "float","for","goto","if","int","long","register",
	                         "return", "short",  "signed",  "sizeof", "static",
	                         "struct", "switch", "typedef", "union","unsigned",
	                         "void",            "volatile",            "while"
	                        );
	$keywords['PHP'] = array (
	                           "__halt_compiler",  "abstract",   "and",  "array",  "as", "break",
	                           "callable", "case", "catch", "class", "clone", "const","continue",
	                           "declare","default", "die", "do", "echo", "else","elseif","empty",
	                           "enddeclare","endfor","endforeach","endif","endswitch","endwhile",
	                           "eval", "exit", "extends", "final",  "for", "foreach", "function",
	                           "global", "goto", "if",  "implements",  "include", "include_once",
	                           "instanceof","insteadof", "interface", "isset","list","namespace",
	                           "new", "or", "print", "private", "protected", "public", "require",
	                           "require_once","return", "static", "switch","throw","trait","try",
	                           "unset",        "use",        "var",        "while",        "xor"
	                          );
	if (empty ($lang)) {
		return $string;
	}
	
	foreach ($lines as $l) {
		$i=0;
		if ($c) {
			$out .= gen_span ($grey);
			if (preg_match ("|^(.*?)\*/(.*)$|",$l,$t)) {
				$out .= $t[1]."*/</span>";
				$l=$t[2];
				$c=0;
			}
			else {
				$out .= $l."</span>";
				$l="";
			}
		}
		else {
			if (substr(trim($l),0,1)=="#") {
				$out .= gen_span($grey).$l."</span>";
				$i=strlen($l);
			}
		}
		if ($s) {
			$out .= gen_span ($red);
			if (preg_match ('|^(.*?)"(.*?)$|',$l,$t)) {
				$out .= $t[1]."\"</span>";
				$l=$t[2];
				$s=0;
			}
			else {
				$out .= $l."</span>";
				$l="";
			}
		}
		for (;$i<strlen($l);$i++) {
			if ($s || $c) {
				$out .= $l[$i];
			}
			if ($l[$i]=='"' && !$c) {
				if (!$s) {
					$out .= gen_span($red).'"';
					$s=1;
				}
				/* this is actually kinda bugged, since something like "\\\"" won't behave
				   as expected. But, being this a beta version, this'll do just fine
				   (note to self: fix this problem checking whether the amount of \ before
				   the " is even or odd
				*/
				else if ($i && (($l[$i-1]!='\\') || $l[$i-1]=='\\' && $l[$i-2]=='\\')) {
					$out .= "</span>";
					$s=0;
				}
			}
			else if (!$s) {
				if (substr($l,$i,2)=="/*") {
					if (!$c) {
						$out .= gen_span($grey)."/*";
						$i++;
						$c=1;
					}
				}
				else if (substr($l,$i,2)=="*/") {
					if ($c) {
						$out .= "/</span>";
						$i++;
						$c=0;
					}
				}
				else if (substr($l,$i,2)=="//") {
					if (!$c) {
						$out .= gen_span($grey).substr($l,$i)."</span>";
						$i=strlen($l);
					}
				}
				else {
					$x=0;
					if (!empty ($keywords[$lang])) {
						foreach ($keywords[$lang] as $kw) {
							if (substr($l,$i,strlen($kw))==$kw && (!$i || (!is_al_git($l[$i-1]) && !is_al_git($l[$i+strlen($kw)])))) {
								$out .= "<b>{$kw}</b>";
								$i+=(strlen($kw)-1);
								$x=1;
							}
						}
					}
					if (!$x) {
						$out .= $l[$i];
					}
				}
			}
		}
		if ($c || $s) {
			$out .= "</span>";
		}
		$out .= "\n";
	}
	return $out;
}

?>
