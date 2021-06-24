<?php 

namespace App\Articles;

use DateTime;
use DateTimeZone;
use Parsedown;

class GetComment {
    public $created_at;
    public $content;
    
    public function __construct()
    {   
        if (is_int($this->created_at) || is_string($this->created_at)) {
            $this->created_at = new DateTime('@'.$this->created_at,new DateTimeZone('UTC'));
            $this->created_at->setTimezone(new DateTimeZone('Europe/Paris'));
        }
    }

    public function getBody()
    {
        $parseDown = new Parsedown();
        $parseDown->setSafeMode(true);
        return $parseDown->text($this->content);
    }

    public function getExcerpt()
    {
        return substr($this->content,0,20);
    }

    
}