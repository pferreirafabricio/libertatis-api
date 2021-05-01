<?php

namespace Source\Controllers;

use Source\Models\Player;
use Source\Models\PlayerHistory;
use Source\Support\Request;

class PlayerHistoryController
{
    private PlayerHistory $playerHistory;

    public function __construct()
    {
        $this->playerHistory = new Player();
    }

    public function index(): string
    {
        try {
            $response = [];

            foreach ($this->playerHistory->find()->fetch(true) as $playerHistory) {
                $response[] = $playerHistory->data();
            }

            return response(['players' => $response])->json();
        } catch (\Exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }

    public function update(): string
    {
        try {
            $request = Request::decode(file_get_contents('php://input'));

            /** @var Player */
            $playerHistory = $this->playerHistory
                ->find('nick = :nick', "nick={$request['nick']}")
                ->fetch();

            if (!$playerHistory) {
                return response([
                    'error' => 'Esse jogador não existe'
                ], 400)->json();
            }

            if (!$playerHistory->required($request)) {
                return response([
                    'error' => 'Verifique os dados e tente novamente'
                ], 400)->json();
            }

            $playerHistory->update($request, 'nick = :nick', "nick={$playerHistory->nick}");

            if ($playerHistory->fail()) {
                return response(['error' => 'Oops! Algo deu errado ao atualizar seu registro'], 400)->json();
            }

            return response(['message' => 'Cadastro atualizado com sucesso' ])->json();
        } catch (\Exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }
}
