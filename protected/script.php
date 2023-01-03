<?php
function check_letter($letter)
{
	return true;
}

$name = 1;
while ($name < 33)
{
	if (isset($_POST[(string)$name]))
	{
		echo check_letter($_POST[(string)$id]);
	}
	$name = $name + 1;
}
?>