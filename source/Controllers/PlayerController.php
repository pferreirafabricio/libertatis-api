<?php

namespace Source\Controllers;

use Source\Models\Player;

class PlayerController
{
    private Player $player;

    public function __construct()
    {
        $this->player = new Player();
    }

    public function index(): string
    {
        try {
            $response = [];

            foreach ($this->player->find()->fetch(true) as $player) {
                $response[] = $player->data();
            }

            return response(['players' => $response])->json();
        } catch (\Exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }

    public function show(array $params): string
    {
        try {
            $nick = (string) $params['nick'];
            $player = $this->player->find('nick = :nick', "nick={$nick}")->fetch();

            if (!$player) {
                return response(['error' => "Jogador '{$nick}' não encontrado"], 400)->json();
            }

            return response(['player' => $player->data()])->json();
        } catch (\Exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }
}
