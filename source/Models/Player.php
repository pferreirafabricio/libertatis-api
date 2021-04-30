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
     * Generic method for find record(s)
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Player
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);

        if ($this->fail() || !$find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    /**
     * Find a user by nick
     */
    public function findById(string $nick, string $columns = "*"): ?Player
    {
        return $this->find("nick = :nick", "nick={$nick}", $columns);
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
