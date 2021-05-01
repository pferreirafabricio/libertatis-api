<?php

namespace Source\Models;

use Source\Core\Model;

class Player extends Model
{
    /**
     * Player constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct("players", [], ["nick", "name"]);
    }

    /**
     * Bootstrap the model instance
     */
    public function bootstrap(string $nick, string $name): Player
    {
        $this->nick = $nick;
        $this->name = $name;
        return $this;
    }
}
