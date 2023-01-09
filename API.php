<?php
require 'protected/code.php';
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
?>