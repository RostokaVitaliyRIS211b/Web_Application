<?php
require 'protected/exceptions.php';

function GetExceptions()
{
    return array(0 => CONN_ERR, 1 => RETR_ERR);
}

function StartGame()
{
    $exceptions = GetExceptions();
	?>
    <script>
        var exceptions = JSON.parse('<?php echo json_encode($exceptions, JSON_UNESCAPED_UNICODE); ?>');
        var currentContent = GetRandomContent(-1); 
        var userWord = RefreshUserWord(null, null);
        var attemptСounter = RefreshAttemptsCount();
    </script> 
    <?php
}
?>

<script>
function GetRandomContent(currentId)
{
    var IdLength;
    $.ajax(
    {
        async: false,
        type: "POST",
        url: './API.php',
        data: {randWord: " ", curId: currentId},
        success: function(json)
        {
            IdLength = JSON.parse(json);
            if (typeof IdLength === "string" && exceptions.includes(IdLength))
            {
                window.location.replace(IdLength + ".html");
            }
            IdLength['Length'] = parseInt(IdLength['Length']);
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

function GetWord(currentId)
{
    var word;
    $.ajax(
    {
        async: false,
        type: "POST",
        url: './API.php',
        data: {Word: " ", curId: currentId},
        success: function(json)
        {
            word = JSON.parse(json);
            if (typeof word === "string" && exceptions.includes(word))
            {
                window.location.replace(word + ".html");
            }
        }
    });
    return word;
}

function IsWin()
{
    if (attemptСounter.NonWritable === 0 || IsAnswer())
    {
        if (IsAnswer())
        {
            document.getElementById('result').innerHTML = 'ПОБЕДА';
        }
        else
        {
            document.getElementById('result').innerHTML = 
                'ПРОИГРЫШ Было загадано слово: ' + GetWord(currentContent['Id']);
        }

        DisableButtons();
        document.getElementById('newGame').innerHTML = 
            '<input type="image" src="images/content/newgame.JPG" class="newgame" id="newgame" onclick = "Update()">';
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
            if (typeof positions === "string" && exceptions.includes(positions))
            {
                window.location.replace(positions + ".html");
            }
        }
    });
    
    if (positions.length !== 0)
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
    document.getElementById(String(buttonId)).src = "images/content/Screen.JPG";
    IsWin();
}

function EnableLetters()
{
	for (let i = 1; i < 33; ++i)
	{
		document.getElementById(String(i)).disabled = false;
        document.getElementById(String(i)).src = "images/letters/" + i + ".JPG";
	}
}

function EnableButtons()
{
    EnableLetters();
    document.getElementById('update').disabled = false;
    document.getElementById('update').src = "images/content/newword.JPG";
}

function DisableLetters()
{
    for (let i = 1; i < 33; ++i)
    {
        document.getElementById(String(i)).disabled = true;
        document.getElementById(String(i)).src = "images/content/Screen.JPG";
    }
}

function DisableButtons()
{
    DisableLetters();
    document.getElementById('update').disabled = true;
    document.getElementById('update').src = "images/content/Screen.JPG";
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

function GetTip(currentId)
{
    var Tip;
    $.ajax(
    {
        async: false,
        type: "POST",
        url: './API.php',
        data: {Tip: " ", curId: currentId},
        success: function(json)
        {
            Tip = JSON.parse(json);
            if (typeof Tip === "string" && exceptions.includes(Tip))
            {
                window.location.replace(Tip + ".html");
            }
        }
    });
    return Tip;
}

function ShowTip()
{
    document.getElementById('tip').innerHTML = 'ПОДСКАЗКА:<br>' + GetTip(currentContent['Id']);
}

function Update()
{
    currentContent = GetRandomContent(currentContent['Id']); 
    userWord = RefreshUserWord(null, null);
    attemptСounter = RefreshAttemptsCount();
    document.getElementById('userword').innerHTML = ChArrayToString(userWord);
    document.getElementById('mess').innerHTML = "";	
    EnableButtons();
    document.getElementById('tip').innerHTML = 
        '<input type="image" src="images/content/tip.JPG" class="ttt" id="Tip" value="Tip" onclick="ShowTip()">';
    document.getElementById('attempts').innerHTML = attemptСounter.NonWritable;
    document.getElementById('result').innerHTML = String(" ");
    document.getElementById('newGame').innerHTML = String(" ");
}

function MinusAttempt()
{
    var obj = { };
    Object.defineProperty(obj, 'NonWritable', 
        {
            value: attemptСounter.NonWritable - 1,
            writable : false,
            enumerable : true,
            configurable : false
        });
    attemptСounter = obj;
    document.getElementById('attempts').innerHTML = attemptСounter.NonWritable;
}

function RefreshAttemptsCount()
{
    var obj = { };
    Object.defineProperty(obj, 'NonWritable', 
        {
            value: 8,
            writable : false,
            enumerable : true,
            configurable : false
        });
    return obj;
}
</script>
