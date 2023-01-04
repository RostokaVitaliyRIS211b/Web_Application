<?php
if (!empty($_POST))	 
	{
		$number = 1;
		$set = false;
		$letter_number = $_POST['radio'];
		while($number < 33 && !$set)
		{
			if($letter_number == $number)
			{
				$set=true;
				echo $number;
			}
			$number = $number + 1;
		}

	}
else
	echo -1;
?>