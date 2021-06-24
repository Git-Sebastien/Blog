<?php

namespace App\Articles;

use DateTime;
use DateTimeZone;

class Comment{
    const LIMIT_TITLE = 3;
    const LIMIT_USERNAME = 3;
    const LIMIT_CONTENT = 5;
    public $content;
    public $title;
    public $username;
    

    public function __construct($content,$title,$username)
    {
        $this->content = $content;
        $this->title = $title;
        $this->username = $username;
    }

    public function isValid():bool
    {
        return empty($this->errors_comment());
    }

    public function errors_comment():?array
    {
        $errors = [];
        strlen($this->content) < self::LIMIT_CONTENT ? $errors['content'] = "Contenu trop court, 5 caractères minimum":"";
        strlen($this->title) < self::LIMIT_TITLE ? $errors['title'] = "Titre trop court, 3 caractères minimum":"";
        strlen($this->username) < self::LIMIT_USERNAME ? $errors['username'] = "Nom d'utilisateur trop court, 3 caractères minimum ":"";

        return $errors;
    }

    public function getDatetime($date)
    {
        if (is_int($date) || is_string($date)) {
            $date = new DateTime('@'.$date,new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Europe/Paris'));
        }
    }
}
