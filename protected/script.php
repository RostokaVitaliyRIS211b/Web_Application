<?php

function StartGame()
{
	?>
    <script>
        var currentContent = GetRandomContent(-1); 
        var userWord = RefreshUserWord(null, null);
        var attemptСounter = GetAttemptsCount();
    </script> 
    <?php
}
?>

<script>
function GetRandomContent(currentId)
{
    var IdLength;
    console.log("ajax");
    $.ajax(
    {
        async: false,
        type: "POST",
        url: './API.php',
        data: {randWord: " ", curId: currentId},
        success: function(json)
        {
            IdLength = JSON.parse(json);
        }
    });
    return IdLength;
}

function RefreshUserWord(letter = null, positions = null)
{
    let uw;
    if (letter !== null && positions !== null)
    {
        uw = userWord;
        for (let i = 0; i < positions.length; ++i)
        {
            uw[positions[i]] = letter;
        }
    }
    else
    {
        uw = new Array(currentContent['Length']);
        for(let i = 0; i < uw.length; ++i)
        {
           uw[i] = '*';
        }
    }
    return uw;
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

function IsWin()
{
    if (attemptСounter == 0 || IsAnswer())
    {
        if (IsAnswer())
        {
            //console.log(2222);
            document.getElementById('result').innerHTML = 'ПОБЕДА';
        }
        else
        {
            //console.log(3333);
            document.getElementById('result').innerHTML = 'ПРОИГРЫШ Было загадано слово: ' + currentContent['Word'];
        }

        DisableButtons();
        document.getElementById('newGame').innerHTML = '<button id = "newgame" onclick = "Update()">Новая игра</button>';
        //document.getElementById('userword').innerHTML = String(currentContent['Word']);
    }
}

function CheckLetter(buttonId, letter)
{
    var positions;
    $.ajax(
    {
        async: false,
        type: "POST",
        url: './API.php',
        data: {letter: letter, curId: currentContent['Id']},
        success: function(json)
        {
            positions = JSON.parse(json);
        }
    });
    
    if (positions.length > 0)
    {
        userWord = RefreshUserWord(letter, positions);
        document.getElementById('mess').innerHTML='есть буква ' + letter;
        document.getElementById('userword').innerHTML = ChArrayToString(userWord);
    }
    else
    {
        MinusAttempt();
        document.getElementById('mess').innerHTML='нет буква ' + letter;
    }

    document.getElementById(String(buttonId)).disabled = true;
    IsWin();
}

function EnableLetters()
{
	for (let i = 1; i < 33; ++i)
	{
		document.getElementById(String(i)).disabled = false;
	}
}

function EnableButtons()
{
    EnableLetters();
    document.getElementById('submit').disabled = false;
}

function DisableLetters()
{
    for (let i = 1; i < 33; ++i)
    {
        document.getElementById(String(i)).disabled = true;
    }
}

function DisableButtons()
{
    DisableLetters();
    document.getElementById('submit').disabled = true;
}

function IsAnswer()
{
    let i = 0;
    while (userWord[i] != '*' && i < userWord.length)
    {
        ++i;
    }
    return i === userWord.length;
}

function GetTip()
{
    document.getElementById('tip').innerHTML = currentContent['Tip'];
}

function Update()
{
    GetRandomContent();
    RefreshContentWord(null);
    document.getElementById('userword').innerHTML = ChArrayToString(userWord);
    document.getElementById('mess').innerHTML = "";	
    EnableButtons();
    document.getElementById('tip').innerHTML = '<button id = "Tip" value ="Tip" onclick="GetTip()">Получить подсказку</button>';
    attemptCounter = GetAttemptsCount();
    document.getElementById('attempts').innerHTML = attemptCounter;
    document.getElementById('result').innerHTML = String(" ");
    document.getElementById('newGame').innerHTML = String(" ");
    console.log(currentContent['Word']);
}

function countUniqChars(str) 
{
  return new Set(str.split('')).size;
}

function GetAttemptsCount()
{
	//return Math.ceil(countUniqChars(currentContent['Word']) * 1.5);
    return 8;
}
</script>
