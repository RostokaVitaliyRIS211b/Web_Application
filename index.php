<?php
require_once 'protected/connect_database.php';
if ($db_induction)
{
    include 'protected/game.php';
}
else
{
    echo '<h1>Error</h1>';
}