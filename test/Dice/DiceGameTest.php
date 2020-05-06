<?php

namespace GB\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceGameTest extends TestCase
{
    /**
     * testing init and roll, asserting returns string of correct size
     */
    public function testDiceRoll()
    {
        $dice = new DiceGame();
        $dice->diceRoll();
        $res = $dice->getLastRoll();
        $this->assertSame(strlen($res), 10);
    }

    /**
     * test get player score
     */
    public function testGetPScore()
    {
        $dice = new DiceGame();
        $res = $dice->getPlayerScore();
        $this->assertSame(0, $res);
    }

    /**
     * test get cpu score
     */
    public function testGetCpuScore()
    {
        $dice = new DiceGame();
        $res = $dice->getCpuScore();
        $this->assertSame(0, $res);
    }

    /**
     * test get pot score
     */
    public function testGetPotScore()
    {
        $dice = new DiceGame();
        $res = $dice->getPot();
        $this->assertSame(0, $res);
    }

    /**
     * test get who's turn it is
     */
    public function testGetTurn()
    {
        $dice = new DiceGame();
        $res = $dice->getTurn();
        $this->assertSame("player", $res);
    }

    /**
     * test change who's turn it is
     */
    public function testChangeTurn()
    {
        $dice = new DiceGame();
        $res = $dice->getTurn();
        $this->assertSame("player", $res);
        $dice->changeTurn();
        $res = $dice->getTurn();
        $this->assertSame("cpu", $res);
        $dice->changeTurn();
        $res = $dice->getTurn();
        $this->assertSame("player", $res);
    }

    /**
     * testing getting last roll sum
     */
    public function testInitarg()
    {
        $dice =  new DiceGame();
        $dice->diceRoll();
        $res = $dice->getLastRollSum();
        $this->assertIsInt($res);
        $this->assertTrue($res > 5);
    }
}
