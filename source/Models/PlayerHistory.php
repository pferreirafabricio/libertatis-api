<?php

namespace Source\Models;

use Source\Core\Model;

class PlayerHistory extends Model
{
    private string $currentDate;

    /**
     * Player constructor
     */
    public function __construct()
    {
        parent::__construct('players_history', [], ['nick', 'date', 'points']);
        $this->currentDate = date('Y-m-d');
    }

    /**
     * Bootstrap the model instance
     */
    public function bootstrap(string $nick, string $date, int $score): PlayerHistory
    {
        $this->nick = $nick;
        $this->date = $date;
        $this->score = $score;
        return $this;
    }

    public function findByNickAndDate(string $nick): ?PlayerHistory
    {
        return $this->find('nick = :nick AND date = :date', "nick={$nick}&date={$this->currentDate}")
            ->fetch();
    }

    public function createIfNotExists(array $data): ?PlayerHistory
    {
        $data['date'] = $this->currentDate;
        $this->create($data);

        return $this->findByNickAndDate($data['nick']);
    }

    public function getLastsPoints(string $nick, int $daysQuantity = 10): ?array
    {
        $date = date('Y-m-d', strtotime("-{$daysQuantity}days"));
        return $this->find(
            'nick = :nick AND date >= :date',
            "nick={$nick}&date={$date}"
        )
         ->fetch(true);
    }

    public function updateScore(int $newPoints): ?int
    {
        return $this->update(
            ['points' => $newPoints],
            'nick = :nick AND date = :date',
            "nick={$this->nick}&date={$this->currentDate}"
        );
    }
}
