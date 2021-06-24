<?php

function db_connect($level = null)
{

    return new PDO('sqlite:' . dirname(__DIR__, $level) . DIRECTORY_SEPARATOR . 'article_database.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
}