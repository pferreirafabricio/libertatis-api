<?php

namespace Source\Controllers;

use Source\Models\Player;
use Source\Support\Request;

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

            foreach ((array) $this->player->find()->fetch(true) as $player) {
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

    public function create(): string
    {
        try {
            $request = Request::decode(file_get_contents('php://input'));

            if (!$this->validate($request)) {
                return response([
                    'error' => 'Dados inválidos'
                ], 400)->json();
            }

            $exists = $this->player
                ->find('nick = :nick', "nick={$request['nick']}", 'nick')
                ->count();

            if ($exists) {
                return response([
                    'error' => 'Já existe um usuário com esse nick'
                ], 400)->json();
            }

            $this->player->bootstrap($request['nick'], $request['name']);

            if (!$this->player->required($request)) {
                return response([
                    'error' => 'Verifique os dados e tente novamente'
                ], 400)->json();
            }

            $this->player->create($request);

            if ($this->player->fail()) {
                return response(['error' => 'Oops! Algo deu errado no seu registro'], 400)->json();
            }

            return response(['message' => 'Cadastro realizado com sucesso' ], 201)->json();
        } catch (\Exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }

    public function update(): string
    {
        try {
            $request = Request::decode(file_get_contents('php://input'));

            if (!$this->validate($request)) {
                return response([
                    'error' => 'Dados inválidos'
                ], 400)->json();
            }

            /** @var Player */
            $player = $this->player
                ->find('nick = :nick', "nick={$request['nick']}")
                ->fetch();

            if (!$player) {
                return response([
                    'error' => 'Esse jogador não existe'
                ], 400)->json();
            }

            if (!$player->required($request)) {
                return response([
                    'error' => 'Verifique os dados e tente novamente'
                ], 400)->json();
            }

            $player->update($request, 'nick = :nick', "nick={$player->nick}");

            if ($player->fail()) {
                return response(['error' => 'Oops! Algo deu errado ao atualizar seu registro'], 400)->json();
            }

            return response(['message' => 'Cadastro atualizado com sucesso' ])->json();
        } catch (\Exception) {
            return response(['error' => 'Algo deu errado ao buscar o usuário'], 500)->json();
        }
    }

    private function validate(array $data): bool
    {
        if (
            !array_key_exists('nick', $data)
            || !filter_var($data['nick'], FILTER_SANITIZE_SPECIAL_CHARS)
            || strlen($data['nick']) > 60
        ) {
            return false;
        }

        if (
            !array_key_exists('name', $data)
            || !filter_var($data['name'], FILTER_SANITIZE_SPECIAL_CHARS)
            || strlen($data['name']) > 120
        ) {
            return false;
        }

        return true;
    }
}
