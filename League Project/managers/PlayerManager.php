<?php
class PlayerManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM players');
        $parameters = [];
        $query->execute($parameters);
        $fetchedPlayers = $query->fetchAll(PDO::FETCH_ASSOC);
        $players = [];
        //enter fetched users from DB into instances array
        foreach ($fetchedPlayers as $player) {
            new Player($player['id'], $player['nickname'], $player['bio'], $player['portrait'], $player['team']);
            array_push($players, $player);
        };
        return $players;
    }

    public function findOneById(int $id): ?Player
    {
        $query = $this->db->prepare('SELECT * FROM players WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $player = $query->fetch(PDO::FETCH_ASSOC);
        //create new player with fetched player
        if ($player === '') {
            return null;
        } else {
            $player = new Player($player['id'], $player['nickname'], $player['bio'], $player['portrait'], $player['team']);
            return $player;
        }
    }
}
