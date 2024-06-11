<?php

class Performance
{
    private ?int $id;

    public function __construct(
        private int $player,
        private int $game,
        private int $points,
        private int $assists
    ) {
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }
    public function setPlayer(string $player): void
    {
        $this->player = $player;
    }

    public function getGame(): string
    {
        return $this->game;
    }
    public function setGame(string $game): void
    {
        $this->game = $game;
    }
    public function getPoints(): string
    {
        return $this->points;
    }
    public function setPoints(string $points): void
    {
        $this->points = $points;
    }
    public function getAssists(): string
    {
        return $this->assists;
    }
    public function setAssists(string $assists): void
    {
        $this->assists = $assists;
    }
}
