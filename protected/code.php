<?php
//ord('А') = 208 . 144
//ord('Я') = 208 . 175

function encodeStringCyr($str, $move_key)
{
	for ($i = 1; $i < strlen($str); ++$i)
    {
    	$ord_i = ord($str[$i]);
		if($ord_i != ord(" ") && $ord_i != 208)
		{
			if ($ord_i + $move_key > 175)
    		{
    			$ord_i = $ord_i + $move_key - 175 + 143;
    		}
    		else
    		{
    			$ord_i = $ord_i + $move_key;
    		} 
        	$str[$i] = chr($ord_i);
		}
    }
	return $str;
}

function decodeStringCyr($str, $move_key)
{
	for ($i = 1; $i < strlen($str); ++$i)
    {
    	$ord_i = ord($str[$i]);
		if($ord_i != ord(" ") && $ord_i != 208)
		{
			if ($ord_i - $move_key < 144)
    		{
    			$ord_i = $ord_i - $move_key + 175 - 143;
    		}
    		else
    		{
    			$ord_i = $ord_i - $move_key;
    		} 
        	$str[$i] = chr($ord_i);
		}
    }
	return $str;
}
?>