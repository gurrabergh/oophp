<?php
namespace GB\Dice;

/**
 *
 */
class Dice
{
    private $dice;
    private $sides;
    private $lastRoll;

    public function __construct($sides = null)
    {
        $this->sides = $sides;
        if ($sides == null) {
            $this->sides = 6;
        }
    }

    /**
    * get the dice's number
    */
    public function getDice()
    {
        $this->dice = rand(1, $this->sides);
        $this->lastRoll = $this->dice;
        return $this->dice;
    }

    public function getSides()
    {
        return $this->sides;
    }
}
