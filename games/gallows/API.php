<?php
require 'protected/connect_database.php';
require 'protected/exceptions.php';

function GetRandContent($db_induction, $except)
{
    if (!$db_induction)
        throw new Exception(CONN_ERR);

    $sql_query = 
            "SELECT Id, char_length(Word) 
             FROM WordsTips 
             WHERE Id != " . $except . " 
             ORDER BY RAND()  
             LIMIT 1";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception(RETR_ERR);

    $IdLength = mysqli_fetch_assoc($query_result);

    return array('Id' => $IdLength['Id'], 'Length' => $IdLength['char_length(Word)']);
}

if (isset($_POST['randWord']) && isset($_POST['curId']))
{
    try
    {
        echo json_encode(GetRandContent($db_induction, $_POST['curId']), JSON_UNESCAPED_UNICODE);
    }
    catch (Exception $ex)
    {
        echo json_encode($ex->getMessage());
    }
}

function GetWordById($db_induction, $wordId)
{
    if (!$db_induction)
        throw new Exception(CONN_ERR);

    $sql_query = "SELECT Word FROM WordsTips WHERE Id = " . $wordId . " LIMIT 1;";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception(RETR_ERR);

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
    try
    {
        echo json_encode(CheckCyrLetter($_POST['letter'], GetWordById($db_induction, $_POST['curId'])));        
    }
    catch (Exception $ex)
    {
        echo json_encode($ex->getMessage());
    }
}

function GetTipById($db_induction, $Id)
{
    if (!$db_induction)
        throw new Exception(CONN_ERR);

    $sql_query = "SELECT Tip FROM WordsTips WHERE Id = " . $Id . " LIMIT 1;";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception(RETR_ERR);

    $word = mysqli_fetch_assoc($query_result);
    return $word['Tip'];
}

if (isset($_POST['Tip']) && isset($_POST['curId']))
{
    try
    {
        echo json_encode(GetTipById($db_induction, $_POST['curId']), JSON_UNESCAPED_UNICODE);
    }
    catch (Exception $ex)
    {
        echo json_encode($ex->getMessage());
    }
}

if (isset($_POST['Word']) && isset($_POST['curId']))
{
    try
    {
        echo json_encode(GetWordById($db_induction, $_POST['curId']));
    }
    catch (Exception $ex)
    {
        echo json_encode($ex->getMessage());
    }
}

function GetAttemptsById($db_induction, $Id)
{
    if (!$db_induction)
        throw new Exception(CONN_ERR);

    $sql_query = "SELECT Attempts FROM WordsTips WHERE Id = " . $Id . " LIMIT 1;";

    $query_result = mysqli_query($db_induction, $sql_query);

    if (!$query_result)
        throw new Exception(RETR_ERR);

    $Attempts = mysqli_fetch_assoc($query_result);
    return $Attempts['Attempts'];
}

function GetMinusAttempts($disabledLetters, $word)
{
    $minus = 0;
    for ($i = 0; $i < strlen($disabledLetters); $i += 1)
    {
        if (ord($disabledLetters[$i]) === 208)
        {
            $curLetter = $disabledLetters[$i] . $disabledLetters[$i + 1];
            if (count(CheckCyrLetter($curLetter, $word)) === 0)
            {
                ++$minus;
            }
            ++$i;
        }
    }
    return $minus;
}

if (isset($_GET['attempts']) && isset($_GET['curId']) && isset($_GET['disabledLetters']))
{ 
    try
    {
        $attempts = GetAttemptsById($db_induction, $_GET['curId']);
        $attempts -= GetMinusAttempts($_GET['disabledLetters'], GetWordById($db_induction, $_GET['curId']));
        if ($attempts < 0)
        {
            echo 0;
        }
        else
        {
            echo json_encode($attempts);
        }
    }
    catch (Exception $ex)
    {
        echo json_encode($ex->getMessage());
    }
}

function IsAnswer($disabledLetters, $word)
{
    $openedLetters = 0;
    for ($i = 0; $i < strlen($disabledLetters); $i += 1)
    {
        if (ord($disabledLetters[$i]) === 208)
        {
            $curLetter = $disabledLetters[$i] . $disabledLetters[$i + 1];
            $openedLetters += count(CheckCyrLetter($curLetter, $word));
            ++$i;
        }
    }
    return $openedLetters === strlen($word) / 2;
}

if (isset($_GET['isAnswer']) && isset($_GET['curId']) && isset($_GET['disabledLetters']))
{ 
    try
    {
        echo json_encode(IsAnswer($_GET['disabledLetters'], GetWordById($db_induction, $_GET['curId'])));
    }
    catch (Exception $ex)
    {
        echo json_encode($ex->getMessage());
    }
}
?>