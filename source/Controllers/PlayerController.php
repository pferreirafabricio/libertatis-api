<?php

namespace Source\Controllers;

use Source\Models\Player;

class PlayerController
{
    public function __construct(private Player $player = new Player())
    {
    }

    public function index(): void
    {
        // return response($this->player->find(""))->json();
    }
}
