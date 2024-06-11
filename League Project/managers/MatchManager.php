<?php
class MatchManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM games');
        $parameters = [];
        $query->execute($parameters);
        $fetchedMatchs = $query->fetchAll(PDO::FETCH_ASSOC);
        $matchs = [];
        //enter fetched users from DB into instances array
        foreach ($fetchedMatchs as $match) {
            $id = $match['id'];
            $match = new Game($match['name'], $match['date'], $match['team_1'], $match['team_2'], $match['winner']);
            $match->setId($id);
            array_push($matchs, $match);
        };
        return $matchs;
    }

    public function findOneById(int $id): ?Game
    {
        $query = $this->db->prepare('SELECT * FROM games WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $match = $query->fetch(PDO::FETCH_ASSOC);
        //create new match with fetched match
        if ($match === '') {
            return null;
        } else {
            $match = new Game($match['name'], $match['date'], $match['team_1'], $match['team_2'], $match['winner']);
            $match->setId($id);
            return $match;
        }
    }
}
