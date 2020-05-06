<?php

namespace GB\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class HistogramTraitTest extends TestCase
{
    /**
     * testing inint without argument
     */
    private $dice;
    protected function setUp(): void
    {

        $this->dice = new DiceGame;
        $this->dice->diceRoll();
    }
    public function testGetHistMin()
    {
        $res = $this->dice->getHistogramMin();
        $this->assertSame(1, $res);
    }

    public function testGetHistSerie()
    {
        $res = $this->dice->getHistogramSerie();
        $this->assertSame(4, count($res));
    }

    public function testGetHistMax()
    {
        $res = $this->dice->getHistogramSerie();
        $res2 = $this->dice->getHistogramMax();
        $this->assertSame($res2, max($res));
    }

    // public function testInitWith()
    // {
    //     $dice = new Dice(3);
    //     $res = $dice->getSides();
    //     $this->assertSame(3, $res);
    // }
    //
    // public function testGetDice()
    // {
    //     $dice = new Dice();
    //     $res = $dice->getdice();
    //     $this->assertIsInt($res);
    // }
}
