<?php
namespace GB\Dice;

/**
 *
 */
class DiceGame implements HistogramInterface
{
    use HistogramTrait;

    private $playerScore;
    private $cpuScore;
    private $turn;
    private $dices;
    private $lastRoll;
    private $pot;
    private $cpuMessage;
    private $serie = [];
    private $min;
    private $max;

    public function __construct()
    {
        $this->dices = new DiceHand();
        $this->turn = "player";
        $this->cpuScore = 0;
        $this->playerScore = 0;
        $this->pot = 0;
        $this->lastRoll = [];
    }

    /**
    * roll the dices and check if you can continue or not -
    * also check if it was the CPU's roll
    */
    public function diceRoll()
    {
        $res = $this->dices->roll();
        $this->lastRoll = $res;
        foreach ($res as $key) {
            array_push($this->serie, $key);
        }
        $this->cpuMessage = null;
        if (in_array(1, $res)) {
            $this->changeTurn();
            $this->pot = 0;
            return;
        }
        $this->pot += array_sum($res);
        if ($this->turn == "cpu") {
            if ($this->cpuScore < $this->playerScore) {
                $this->saveCpuSum();
            } elseif ($this->pot > 14 or ($this->cpuScore + $this->pot >= 100)) {
                $this->saveCpuSum();
            }
            return;
        }
    }

    /**
    * method for player to save the score
    */
    public function saveSum()
    {
        $this->playerScore += $this->pot;
        $this->changeTurn();
        $this->pot = 0;
        $this->lastRoll = [];
        return;
    }

    /**
    * cpu save score
    */
    public function saveCpuSum()
    {
        $this->cpuScore += $this->pot;
        $this->changeTurn();
        $this->pot = 0;
        $res = $this->getLastRoll();
        $this->lastRoll = [];
        $this->cpuMessage = "The computer rolled " . $res . " and chose to save the pot.";
        return;
    }

    /**
    * change turn between player and cpu
    */
    public function changeTurn()
    {
        if ($this->turn == "player") {
            $this->turn = "cpu";
        } else {
            $this->turn = "player";
        }
    }

    /**
    * get players score
    */
    public function getCpuScore()
    {
        return $this->cpuScore;
    }

    /**
    * get cpu score
    */
    public function getPlayerScore()
    {
        return $this->playerScore;
    }

    /**
    * get sum of last roll
    */
    public function getLastRollSum()
    {
        return $this->dices->sum();
    }

    /**
    * get the last rolled dices' values
    */
    public function getLastRoll()
    {
        return implode(", ", $this->lastRoll);
    }

    /**
    * display message from computer after computer saved the pot
    */
    public function getCpuMessage()
    {
        return $this->cpuMessage;
    }

    /**
    * show the current pot
    */
    public function getPot()
    {
        return $this->pot;
    }

    /**
    * show who's turn it is
    */
    public function getTurn()
    {
        return $this->turn;
    }

    public function getAsText()
    {
        $string = "";
        $num = array_count_values($this->serie);
        ksort($num);
        $array = [];

        for ($i=$this->min; $i <=$this->max; $i++) {
            $array[$i] = 0;
        }
        foreach ($num as $key => $value) {
            $array[$key] = $value;
        }
        foreach ($array as $key => $value) {
            $string .= strval($key) . ": ";
            for ($i=0; $i < $value; $i++) {
                $string .= "*";
            }
            $string .= "\n";
        }
        return $string;
    }
}
