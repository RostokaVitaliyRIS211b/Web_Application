<?php
function get_rand_pair(&$words_array, &$tips_array)
{
    $rand = random_int(0, min(count($words_array), count($tips_array)));
    $result_array['Word'] = $words_array[$rand];
    $result_array['Tip'] = $tips_array[$rand];
    unset($words_array[$rand]);
    unset($tips_array[$rand]);
    return $result_array;
}

$get_wordstips_query = "SELECT * FROM WordsTips";
$query_result = mysqli_query($db_induction, $get_wordstips_query);
$words;
$tips;
if ($query_result)
{
    while ($row = mysqli_fetch_array($query_result))
    {
        $words[] = $row['Word'];
        $tips[] = $row['Tip'];
    }
}
else
{
    //cant find game content in database
}

var_dump(get_rand_pair($words, $tips));
?>

<DOCTYPE html>
<html lang="ru">
    <head>
       	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    </head>
    <body>
        <form class ="Letters" method="POST"> 
            <br><input type = "radio" name = "radio" value = "1" checked="checked"  />
            <br><input type = "radio" name = "radio" value = "2"  />
            <br><input type = "radio" name = "radio" value = "3"  />
            <br><input type = "radio" name = "radio" value = "4"  />
            <br><input type = "radio" name = "radio" value = "5"  />
            <br><input type = "radio" name = "radio" value = "6"  />
            <br><input type = "radio" name = "radio" value = "7"  />
            <br><input type = "radio" name = "radio" value = "8"  />
            <br><input type = "radio" name = "radio" value = "9"  />
            <br><input type = "radio" name = "radio" value = "10"  />
            <br><input type = "radio" name = "radio" value = "11"  />
            <br><input type = "radio" name = "radio" value = "12"  />
            <br><input type = "radio" name = "radio" value = "13"  />
            <br><input type = "radio" name = "radio" value = "14"  />
            <br><input type = "radio" name = "radio" value = "15"  />
            <br><input type = "radio" name = "radio" value = "16"  />
            <br><input type = "radio" name = "radio" value = "17"  />
            <br><input type = "radio" name = "radio" value = "18"  />
            <br><input type = "radio" name = "radio" value = "19"  />
            <br><input type = "radio" name = "radio" value = "20"  />
            <br><input type = "radio" name = "radio" value = "21"  />
            <br><input type = "radio" name = "radio" value = "22"  />
            <br><input type = "radio" name = "radio" value = "23"  />
            <br><input type = "radio" name = "radio" value = "24"  />
            <br><input type = "radio" name = "radio" value = "25"  />
            <br><input type = "radio" name = "radio" value = "26"  />
            <br><input type = "radio" name = "radio" value = "27"  />
            <br><input type = "radio" name = "radio" value = "28"  />
            <br><input type = "radio" name = "radio" value = "28"  />
            <br><input type = "radio" name = "radio" value = "29"  />
            <br><input type = "radio" name = "radio" value = "30"  />
            <br><input type = "radio" name = "radio" value = "31"  />
            <br><input type = "radio" name = "radio" value = "32"  />
            <button type = "submit" name = "submit">Потвердите выбор</button>
        </form>

        <div class="mess"></div>

        <script type="text/javascript">
        $('.Letters').submit(function(e) {
            e.preventDefault();
            let m = $('.mess');
            var form = $(this);
            $.ajax({
                type: "POST",
                url: "/protected/script.php",
                data: form.serialize(),
                success: function(x)
                {
                    form.find(`:input[value = ${String(x)}]`).prop('disabled',true);
                    m.html(String(x));
                }//, 
                /*error: function()
                {
                    m.html('error');
                }*/
            });
        });
        </script>
    </body>
</html>