<!DOCTYPE HTML>
<html lang="ru">
    <head>
        <?php
        require_once 'protected/connect_database.php';
        require_once 'protected/script.php';
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width">
        <meta charset="utf-8"/>
        <title>Игра Виселица</title>
    </head>

    <body>
        <?php
        StartGame();
        include 'protected/game.html';
        ?>
    </body>
</html>