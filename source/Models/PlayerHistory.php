<?php

namespace Source\Models;

use DateTime;
use Source\Core\Model;

class PlayerHistory extends Model
{
    /**
     * Player constructor
     */
    public function __construct()
    {
        parent::__construct('players_history', [], ['nick', 'date', 'points']);
    }

    /**
     * Bootstrap the model instance
     */
    public function bootstrap(string $nick, DateTime $date, int $score): PlayerHistory
    {
        $this->nick = $nick;
        $this->date = $date;
        $this->score = $score;
        return $this;
    }
}
