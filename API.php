<?php
require 'protected/connect_database.php';

function GetRandContent($db_induction, $except)
{
    if (!$db_induction)
        throw new Exception("Ошибка подключения к базе данных.");

    $sql_query = 
            "SELECT Id, char_length(Word) 
             FROM WordsTips 
             WHERE Id != " . $except . " 
             ORDER BY RAND()  
             LIMIT 1";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception('Ошибка получения данных.');

    $IdLength = mysqli_fetch_assoc($query_result);

    return array('Id' => $IdLength['Id'], 'Length' => $IdLength['char_length(Word)']);
}

if (isset($_POST['randWord']) && isset($_POST['curId']))
{
    echo json_encode(GetRandContent($db_induction, $_POST['curId']), JSON_UNESCAPED_UNICODE);
}

function GetWordById($db_induction, $wordId)
{
    if (!$db_induction)
        throw new Exception("Ошибка подключения к базе данных.");

    $sql_query = "SELECT Word FROM WordsTips WHERE Id = " . $wordId . " LIMIT 1;";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception('Ошибка получения данных.');

    $word = mysqli_fetch_assoc($query_result);
    return $word['Word'];
}

function CheckCyrLetter($letter, $word)
{
    $letterOrd = ord($letter[1]);
    $positions = array();
    for ($i = 1; $i < strlen($word); $i+=2)
    {
        if ($letterOrd === ord($word[$i]))
        {
            $positions[] = ($i - 1) / 2;
        }
    }
    return $positions;
}

if (isset($_POST['letter']) && isset($_POST['curId']))
{
    echo json_encode(CheckCyrLetter($_POST['letter'], GetWordById($db_induction, $_POST['curId'])));
}

function GetTipById($db_induction, $Id)
{
    if (!$db_induction)
        throw new Exception("Ошибка подключения к базе данных.");

    $sql_query = "SELECT Tip FROM WordsTips WHERE Id = " . $Id . " LIMIT 1;";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception('Ошибка получения данных.');

    $word = mysqli_fetch_assoc($query_result);
    return $word['Tip'];
}

if (isset($_POST['Tip']) && isset($_POST['curId']))
{
    echo json_encode(GetTipById($db_induction, $_POST['curId']), JSON_UNESCAPED_UNICODE);
}
?>