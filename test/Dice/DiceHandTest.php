<?php

namespace GB\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceHandTest extends TestCase
{
    /**
     * testing init and roll, asserting returns array of correct size
     */
    public function testRoll()
    {
        $dice = new DiceHand();
        $res = $dice->roll();
        $this->assertIsArray($res);
        $this->assertSame(count($res), 4);
    }

    /**
     * testing sum method
     */
    public function testGetDice()
    {
        $dice = new DiceHand();
        $res = $dice->roll();
        $res = $dice->sum();
        $this->assertIsInt($res);
    }

    /**
     * testing init with arg
     */
    public function testInitarg()
    {
        $dice =  new DiceHand(3);
        $res = $dice->roll();
        $this->assertIsArray($res);
        $this->assertSame(count($res), 3);
    }
}
