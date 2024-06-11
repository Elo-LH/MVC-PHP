<?php
class TeamManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM teams');
        $parameters = [];
        $query->execute($parameters);
        $fetchedTeams = $query->fetchAll(PDO::FETCH_ASSOC);
        $teams = [];
        //enter fetched users from DB into instances array
        foreach ($fetchedTeams as $team) {
            new Team($team['id'], $team['name'], $team['description'], $team['logo']);
            array_push($teams, $team);
        };
        return $teams;
    }

    public function findOneById(int $id): ?team
    {
        $query = $this->db->prepare('SELECT * FROM teams WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $team = $query->fetch(PDO::FETCH_ASSOC);
        //create new team with fetched team
        if ($team === '') {
            return null;
        } else {
            $team = new Team($team['id'], $team['name'], $team['description'], $team['logo']);
            return $team;
        }
    }
}
