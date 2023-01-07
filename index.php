<!DOCTYPE HTML>
<html lang="ru">
    <head>
        <?php
        require_once 'protected/connect_database.php';
        require_once 'protected/script.php';
        ?>
        <meta name="viewport" content="width=device-width">
        <meta charset="utf-8"/>
        <title>Игра Виселица</title>
    </head>

    <body>
        <?php
        try
        {
            StartGame($db_induction);
            include 'protected/game.html';
        }
        catch (Exception $e)
        {
            echo '<h1 align="center">Error: ' . $e->getMessage() . '</h1>';
        }
        ?>
    </body>
</html>