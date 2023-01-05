<?php
require '..\encoding.php';

function check_letter($letter)
{
	if (strpos((string)$global_pair['Word'], (string)$letter) == false)
	{
		return false;
	}
	else
	{
		return true;
	}
}

if (!empty($_POST))	 
	{
		$number = 1;
		$set = false;
		$letter_number = $_POST['radio'];
		while($number < 32 && !$set)
		{
			if($letter_number == $number)
			{
				$set = true;
				$A_code = utf8ToCode('А');
				$this_code = $A_code + $number - 1;
				$isLetter = check_letter(codeToUtf8($this_code));
				if ($isLetter)
				{
					echo 'true ' . (string)$number;
				}
				else
				{
					echo 'false ' . (string)$number;
				}
			}
			$number = $number + 1;
		}
	}
else
	echo -1;
?>