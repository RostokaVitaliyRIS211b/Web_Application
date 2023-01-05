<?php
require_once 'protected/connect_database.php';
$last_index = -1;
function get_rand_pair(&$words_array, &$tips_array)
{
    do
    {
        $rand = random_int(0, min(count($words_array), count($tips_array)));    
    } while($rand == $last_index);
    $result_array['Word'] = $words_array[$rand];
    $result_array['Tip'] = $tips_array[$rand];
    $last_index = $rand;
    return $result_array;
}
function GetUserWord($a)
{
    $num = strlen($a);
    while($num>0)
    {
        echo '*';
        $num = $num -1;
    }
}
if ($db_induction)
{
    $sql1 = "SELECT Word,Tip FROM WordsTips";
    $result = mysqli_query($db_induction,$sql1);
    while ($row = mysqli_fetch_array($result)) 
    {
        $words[] = $row['Word'];
        $tips[] = $row['Tip'];
    }
    $count = 6;
    $array = get_rand_pair($words,$tips);
    $word = $array['Word'];
    $tip = $array['Tip'];
    $userWord = GetUserWord($word);
    include 'protected/game.php';
}
else
{
    echo '<h1>Error</h1>';
}