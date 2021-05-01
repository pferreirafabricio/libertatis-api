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

    /**
     * Update a record by nick
     */
    public function updateById(array $data, string $nick): ?int
    {
        return $this->update($data, "nick = :nick", "nick={$nick}");
    }

    /**
     * Remove a record by nick
     */
    public function remove(string $nick): ?int
    {
        return $this->delete("nick = :nick", "nick={$nick}");
    }
}
