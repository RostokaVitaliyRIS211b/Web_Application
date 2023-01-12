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
	return array.join(' ');
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
    var isAnswer = IsAnswer(currentContent['Id']);
    if (GetAttempts(currentContent['Id']) === 0 || isAnswer)
    {
        if (isAnswer)
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
    DisableL(buttonId);

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
        document.getElementById('attempts').innerHTML = GetAttempts(currentContent['Id']);
        document.getElementById('mess').innerHTML='нет буква ' + letter;
    }

    IsWin();
}

function EnableL(buttonId)
{
    document.getElementById(buttonId).disabled = false;
    document.getElementById(buttonId).src = "images/letters/" + buttonId + ".JPG";
}

function EnableLetters()
{
	for (let i = 1; i < 33; ++i)
	{
		EnableL(String(i));
	}
}

function EnableButtons()
{
    EnableLetters();
    document.getElementById('update').disabled = false;
    document.getElementById('update').src = "images/content/newword.JPG";
}

function DisableL(buttonId)
{
    document.getElementById(String(buttonId)).disabled = true;
    document.getElementById(String(buttonId)).src = "images/content/Screen.JPG";
}

function DisableLetters()
{
    for (let i = 1; i < 33; ++i)
    {
        DisableL(String(i));
    }
}

function DisableButtons()
{
    DisableLetters();
    document.getElementById('update').disabled = true;
    document.getElementById('update').src = "images/content/Screen.JPG";
}

function IsAnswer(currentId)
{
    var isAnswer;

    var disabledLetters = new Array();
    for (let i = 1; i < 33; ++i)
    {
        if (document.getElementById(String(i)).disabled === true)
        {
            disabledLetters.push(document.getElementById(String(i)).value);
        }
    }

    $.ajax(
    {
        async: false,
        type: "GET",
        url: './API.php',
        data: {isAnswer: " ", curId: currentId, disabledLetters: disabledLetters.join('')},
        success: function(json)
        {
            isAnswer = JSON.parse(json);
            if (typeof isAnswer === "string" && exceptions.includes(isAnswer))
            {
                window.location.replace(isAnswer + ".html");
            }
        }
    });

    return isAnswer;

    /*let i = 0;
    while (userWord[i] != '*' && i < userWord.length)
    {
        ++i;
    }
    return i === userWord.length;*/
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
    document.getElementById('userword').innerHTML = ChArrayToString(userWord);
    document.getElementById('mess').innerHTML = "";	

    EnableButtons();
    document.getElementById('attempts').innerHTML = GetAttempts(currentContent['Id']);

    document.getElementById('tip').innerHTML = 
        '<input type="image" src="images/content/tip.JPG" class="ttt" id="Tip" value="Tip" onclick="ShowTip()">';
    document.getElementById('result').innerHTML = String(" ");
    document.getElementById('newGame').innerHTML = String(" ");
}

function GetAttempts(currentId)
{
    var attemptsCount;

    var disabledLetters = new Array();
    for (let i = 1; i < 33; ++i)
    {
        if (document.getElementById(String(i)).disabled === true)
        {
            disabledLetters.push(document.getElementById(String(i)).value);
        }
    }

    $.ajax(
    {
        async: false,
        type: "GET",
        url: './API.php',
        data: {attempts: " ", curId: currentId, disabledLetters: disabledLetters.join('')},
        success: function(json)
        {
            attemptsCount = JSON.parse(json);
            if (typeof attemptsCount === "string" && exceptions.includes(attemptsCount))
            {
                window.location.replace(attemptsCount + ".html");
            }
        }
    });

    return attemptsCount;
}
</script>
