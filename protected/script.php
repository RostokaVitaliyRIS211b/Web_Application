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
        var userWord = InitUserWord();
        var isLetter = null;
        var attemptСounter = GetAttemptsCount();
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
    } while(rand === lastIndex);

    lastIndex = rand;

    return wordsTipsArray[rand];
}

function InitUserWord()
{
	let uw = new Array(currentContent['Word'].length);
    for(let i = 0; i < currentContent['Word'].length; ++i)
    {
       uw[i] = '*';
    }
    return uw;
}

function RefreshUserWord(letter=null)
{
    if (letter)
    {
        for (let i = 0; i < currentContent['Word'].length; ++i)
        {
            if ((currentContent['Word'])[i] === letter)
            {
                userWord[i] = letter;
            }
        }
    }
    else
    {
    	userWord = InitUserWord();
    }
}

function ChArrayToString(array)
{
	return array.join(" ");
}

function MinusAttempt()
{
	attemptСounter = attemptСounter - 1;
    document.getElementById('attempts').innerHTML = attemptСounter;
}

function CheckLetter(buttonId, letter)
{
    if (currentContent['Word'].includes(letter))
    {
        document.getElementById('mess').innerHTML='есть буква ' + letter;
        RefreshUserWord(letter);
        document.getElementById('userword').innerHTML = ChArrayToString(userWord);	
    }
	else
	{
        document.getElementById('mess').innerHTML='нет буква ' + letter;
        MinusAttempt();
	}
    document.getElementById(String(buttonId)).disabled = true;
}

function EnableLetters()
{
	for (let i = 1; i < 33; ++i)
	{
		document.getElementById(String(i)).disabled = false;
	}
}

function Update()
{
    currentContent = GetRandPair(content);
    RefreshUserWord(null);
    document.getElementById('userword').innerHTML = ChArrayToString(userWord);
    document.getElementById('mess').innerHTML = "";	
    EnableLetters();
    attemptCounter = GetAttemptsCount();
    document.getElementById('attempts').innerHTML = attemptCounter;
    console.log(currentContent['Word']);
}

function countUniqChars(str) 
{
  return new Set(str.split('')).size;
}

function GetAttemptsCount()
{
	console.log(countUniqChars(currentContent['Word']) + " * 1.5 = " + Math.ceil(currentContent['Word'].length * 1.5));
	return Math.ceil(countUniqChars(currentContent['Word']) * 1.5);
}
</script>
