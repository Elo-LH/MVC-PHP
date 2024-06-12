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

    public function getTeam1(int $id): ?string
    {
        $query = $this->db->prepare('SELECT teams.name FROM teams JOIN games ON teams.id = games.team_1 WHERE games.id = :id LIMIT 1');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $team1 = $query->fetch(PDO::FETCH_ASSOC);
        //create new match with fetched match
        if ($team1 === '') {
            return null;
        } else {
            return $team1['name'];
        }
    }
    public function getTeam2(int $id): ?string
    {
        $query = $this->db->prepare('SELECT teams.name FROM teams JOIN games ON teams.id = games.team_2 WHERE games.id = :id LIMIT 1');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $team2 = $query->fetch(PDO::FETCH_ASSOC);
        //create new match with fetched match
        if ($team2 === '') {
            return null;
        } else {
            return $team2['name'];
        }
    }
    public function getWinner(int $id): ?string
    {
        $query = $this->db->prepare('SELECT teams.name FROM teams JOIN games ON teams.id = games.winner WHERE games.id = :id LIMIT 1');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $winner = $query->fetch(PDO::FETCH_ASSOC);
        //create new match with fetched match
        if ($winner === '') {
            return null;
        } else {
            return $winner['name'];
        }
    }
    public function getPerformances(int $id): array
    {
        $query = $this->db->prepare('SELECT * FROM games JOIN player_performance ON games.id = player_performance.game WHERE games.id = :id');
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
    public function getLatestMatch(): ?Game
    {
        $query = $this->db->prepare('SELECT * FROM games ORDER BY date DESC LIMIT 1');
        $parameters = [];
        $query->execute($parameters);
        $match = $query->fetch(PDO::FETCH_ASSOC);
        //create new match with fetched match
        if ($match === '') {
            return null;
        } else {
            $id = $match['id'];
            $match = new Game($match['name'], $match['date'], $match['team_1'], $match['team_2'], $match['winner']);
            $match->setId($id);
            return $match;
        }
    }
}
