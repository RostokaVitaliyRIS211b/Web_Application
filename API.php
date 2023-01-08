<?php
require 'protected/connect_database.php';
$lastindex = -1;
function GetGameContent($db_induction)
{
	if (!$db_induction)
		throw new Exception("Ошибка подключения к базе данных.");
		
	$sql_query = "SELECT * FROM WordsTips";
    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
    	throw new Exception('Ошибка получения данных.');

    $WordsTips;
    while ($row = mysqli_fetch_array($query_result))
    {
        $word_tip['Word'] = $row['Word'];
        $word_tip['Tip'] = $row['Tip'];
        $WordsTips[] = $word_tip;
    }
    return $WordsTips;
}
function GetRandPair($array,$lastindex)
{
    $index = 0;
    do{
        $index = rand(0,count($array));
    }while($index == $lastindex);
    $lastindex = $index;
    return $array[$index];
}
if (isset($_POST['randWord']) && isset($_POST['randTip']))
{
    echo json_encode(GetRandPair(GetGameContent($db_induction),$lastindex));
}
?>