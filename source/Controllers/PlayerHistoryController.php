<?php

namespace Source\Controllers;

use Source\Models\PlayerHistory;
use Source\Support\Request;

class PlayerHistoryController
{
    private PlayerHistory $playerHistory;

    public function __construct()
    {
        $this->playerHistory = new PlayerHistory();
    }

    public function index(array $data): string
    {
        try {
            $nick = (string) $data['nick'];
            $response = [];

            foreach ((array) $this->playerHistory->getLastsPoints($nick) as $history) {
                $response[] = (!is_null($history) ? $history->data() : null);
            }

            return response(['history' => $response])->json();
        } catch (\Exception $exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }

    public function update(): string
    {
        try {
            $request = Request::decode(file_get_contents('php://input'));

            /** @var PlayerHistory */
            $playerHistory = $this->playerHistory->findByNickAndDate($request['nick']);

            if (!$playerHistory) {
                $playerHistory = $this->playerHistory->createIfNotExists($request);
            }

            $playerHistory->updateScore($request['points']);

            if ($playerHistory->fail()) {
                return response(['error' => 'Oops! Algo deu errado ao atualizar seus pontos'], 400)->json();
            }

            return response(['message' => 'Pontuação atualizada com sucesso'])->json();
        } catch (\Exception $exception) {
            return response(['error' => 'Algo deu errado ao buscar a pontuação'], 500)->json();
        }
    }
}
