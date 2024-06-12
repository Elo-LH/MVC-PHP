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
            $id = $player['id'];
            $player = new Player($player['nickname'], $player['bio'], $player['portrait'], $player['team']);
            $player->setId($id);
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
            $player = new Player($player['nickname'], $player['bio'], $player['portrait'], $player['team']);
            $player->setId($id);
            return $player;
        }
    }
    public function getMedia(int $id): ?Media
    {
        $query = $this->db->prepare('SELECT players.id as player_id, media.id as media_id, url, alt  FROM players JOIN media ON players.portrait = media.id WHERE players.id = :id');
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
    public function getTeam(int $id): ?Team
    {
        $query = $this->db->prepare('SELECT * FROM players JOIN teams ON players.team = teams.id WHERE players.id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $team = $query->fetch(PDO::FETCH_ASSOC);
        //create new player with fetched player
        if ($team === '') {
            return null;
        } else {
            $team = new Team($team['name'], $team['description'], $team['logo']);
            $team->setId($id);
            return $team;
        }
    }
    public function getPerformance(int $id): array
    {
        $query = $this->db->prepare('SELECT * FROM players JOIN player_performance ON players.id = player_performance.player WHERE players.id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $fetchedPerformances = $query->fetchAll(PDO::FETCH_ASSOC);
        $performances = [];
        //enter fetched performances from DB into instances array
        foreach ($fetchedPerformances as $performance) {
            $id = $performance['id'];
            $performance = new Performance($performance['player'], $performance['game'], $performance['points'], $performance['assists']);
            $performance->setId($id);
            array_push($performances, $performance);
        };
        return $performances;
    }
    public function getTeammates(int $id): array
    {
        $query = $this->db->prepare('SELECT * FROM players  WHERE team = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $fetchedPlayers = $query->fetchAll(PDO::FETCH_ASSOC);
        $players = [];
        //enter fetched players from DB into instances array
        foreach ($fetchedPlayers as $player) {
            $id = $player['id'];
            $player = new Player($player['nickname'], $player['bio'], $player['portrait'], $player['team']);
            $player->setId($id);
            array_push($players, $player);
        };
        return $players;
    }

    public function get3RandomPlayers(): array
    {
        $query = $this->db->prepare('SELECT * FROM players ORDER BY RAND() LIMIT 3 ');
        $parameters = [];
        $query->execute($parameters);
        $fetchedPlayers = $query->fetchAll(PDO::FETCH_ASSOC);
        $players = [];
        //enter fetched users from DB into instances array
        foreach ($fetchedPlayers as $player) {
            $id = $player['id'];
            $player = new Player($player['nickname'], $player['bio'], $player['portrait'], $player['team']);
            $player->setId($id);
            array_push($players, $player);
        };
        return $players;
    }
}
