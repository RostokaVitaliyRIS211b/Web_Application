<?php
require_once 'protected/connect_database.php';
function GetRandomWordAndTip()
{
    require_once 'protected/connect_database.php';
    if ($db_induction)
    {
    $min = 1;
    $max = 11;
    $number = rand($min,$max);
    $sql1 = 'SELECT Word FROM wordstips';
    $sql2 = 'SELECT Tip FROM wordstips';
    $words = mysqli_query($db_induction,$sql1);
    $tips = mysqli_query($db_induction,$sql2);
    $array = array(
        0=>$words[$number],
        1=>$tips[$number]
    );
    echo $array;
    }
    else
    echo null;
}    
if ($db_induction)
{
    $wordaTip = GetRandomWordAndTip();
    $word;
    if($wordaTip != null)
        $word = 'gay';
    else
        $word = 'good';
    $tip = $wordaTip[1];
    include 'protected/game.php';
    
}
else
{
    echo '<h1>Error</h1>';
}