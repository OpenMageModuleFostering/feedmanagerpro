<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

function func_froogle_convert($str, $max_len = false)
{
	static $tbl = false;
	if ($tbl === false)
		$tbl = array_flip(get_html_translation_table(HTML_ENTITIES));
	
	$str = str_replace(array("\n","\r","\t"), array(" ", "", " "), $str);
	$str = strtr($str, $tbl);
	if ($max_len > 0 && strlen($str) > $max_len) {
		$str = preg_replace("/\s+?\S+.{".intval(strlen($str)-$max_len-1+FROOGLE_TAIL_LEN)."}$/Ss", "", $str).FROOGLE_TAIL;
		if (strlen($str) > $max_len)
		{
			$str = substr($str, 0, $max_len-FROOGLE_TAIL_LEN).FROOGLE_TAIL;
		}
	}
	return $str;
}

function addPrefixSuffix($str,$cnt,$arr_storeformat,$arr_prefix_title,$arr_prefix_value,$arr_suffix_title,$arr_suffix_value,$arr_suffix1_title,$arr_suffix1_value)
{
	$newstr = $str;
	if(in_array($arr_storeformat[$cnt],$arr_prefix_title))
	{
		foreach($arr_prefix_title as $tt=>$tv)
		{
			if($tv == $arr_storeformat[$cnt])
			{
				$Prefix = $arr_prefix_value[$tt];
			}
		}
		$newstr = $Prefix.$newstr;
	}
	
	if(in_array($arr_storeformat[$cnt],$arr_suffix_title))
	{
		foreach($arr_suffix_title as $tt=>$tv)
		{
			if($tv == $arr_storeformat[$cnt])
			{
				$Suffix = $arr_suffix_value[$tt];
			}
		}
		$newstr=$newstr.$Suffix;
	}
	
	if(in_array($arr_storeformat[$cnt],$arr_suffix1_title))
	{
		foreach($arr_suffix1_title as $tt=>$tv)
		{
			if($tv == $arr_storeformat[$cnt])
			{
				$Suffix1 = $arr_suffix1_value[$tt];
			}
		}
		$newstr=$newstr.$Suffix1;
	}
	return $newstr;
}

function getProductImagePath($str,$ProductMediaModel, $image_location)
{
	$newstr = "";
	if($str != "")
	{
		if(strstr($str,'http'))
		{
			$newstr = $str;
		}
		else
		{
			$image_location = str_replace("index.php/","",$image_location);
			$strreplace = "index.php/";
			if(strstr(Mage::getUrl(),"createfeed.php"))
				$strreplace = "createfeed.php/";
			$newurl = str_replace($strreplace,"",Mage::getUrl());
			$url = $ProductMediaModel->getBaseMediaUrl();
			$newstr = $url.$str;
			$newstr = str_replace($newurl,$image_location,$newstr);
			$newstr = str_replace("https","http",$newstr);
		}
	}
	return $newstr;
}