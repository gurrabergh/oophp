<?php

namespace GB\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    /**
     * testing inint without argument
     */
    public function testInitWithout()
    {
        $dice = new Dice();
        $res = $dice->getSides();
        $this->assertSame(6, $res);
    }

    public function testInitWith()
    {
        $dice = new Dice(3);
        $res = $dice->getSides();
        $this->assertSame(3, $res);
    }

    public function testGetDice()
    {
        $dice = new Dice();
        $res = $dice->getdice();
        $this->assertIsInt($res);
    }
}
