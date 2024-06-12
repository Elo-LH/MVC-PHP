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
            $id = $team['id'];
            $team = new Team($team['name'], $team['description'], $team['logo']);
            $team->setId($id);
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
            $team = new Team($team['name'], $team['description'], $team['logo']);
            $team->setId($id);
            return $team;
        }
    }
    public function getMedia(int $id): ?Media
    {
        $query = $this->db->prepare('SELECT teams.id as team_id, media.id as media_id, url, alt  FROM teams JOIN media ON teams.logo = media.id WHERE teams.id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $media = $query->fetch(PDO::FETCH_ASSOC);
        //create new player with fetched player
        if ($media === '') {
            return null;
        } else {
            $media = new Media($media['url'], $media['alt']);
            $media->setId($id);
            return $media;
        }
    }
    public function getRandomTeam(): ?team
    {
        //fetch teamNumber
        $query = $this->db->prepare('SELECT id FROM teams ');
        $parameters = [];
        $query->execute($parameters);
        $ids = $query->fetchAll(PDO::FETCH_ASSOC);
        //get random id
        $random = rand(0, (count($ids) - 1));
        //fetch team with random id
        $query = $this->db->prepare('SELECT * FROM teams WHERE id = :id');
        $parameters = [
            'id' => $ids[$random]['id'],
        ];
        $query->execute($parameters);
        $team = $query->fetch(PDO::FETCH_ASSOC);
        //create new team with fetched team
        if ($team === '') {
            return null;
        } else {
            $team = new Team($team['name'], $team['description'], $team['logo']);
            $team->setId($ids[$random]['id']);
            return $team;
        }
    }
}
