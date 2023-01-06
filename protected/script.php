<?php
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

function StartGame($db_induction)
{
	$array = GetGameContent($db_induction);
	?>
    <script>
    	var content = JSON.parse('<?php echo json_encode($array, JSON_UNESCAPED_UNICODE); ?>');
        var lastIndex = -1;
        var currentContent = GetRandPair(content);
        var userWord = GetUserWord(currentContent['Word']);
        console.log(currentContent['Word']);
    </script> 
    <?php
}
?>

<script>
function GetRandInt(min, max)
{
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function GetRandPair(wordsTipsArray)
{
    let rand = -1;

    do
    {
        rand = GetRandInt(0, wordsTipsArray.length - 1);    
    } while(rand == lastIndex);

    lastIndex = rand;

    return wordsTipsArray[rand];
}

function GetUserWord(word)
{
    return "*".repeat(word.length);
}

function check_letter(letter)
{
    if (currentContent['Word'].includes(letter))
    {
        for (let i = 0; i < userWord.length; ++i)
        {
            if ((currentContent['Word'])[i] == letter)
            {
                userWord[i] = letter;
            }
        }
        return true;
    }

    return false;
}
</script>