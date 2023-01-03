<?php
if (!empty($_POST))	 
	{
		$name = 1;
		$set = false;
		$gay = $_POST['radio'];
		while($name<33 && !$set)
		{
			if($gay==$name)
			{
				$set=true;
				echo $name;
			}
			$name=$name+1;
		}

	}
else
	echo -1;
?>