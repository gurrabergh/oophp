<?php
namespace GB\Dice;

/**
 *
 */
class DiceHand
{
    private $dices;
    private $values;

    public function __construct(int $dices = 4)
    {
        $this->dices  = [];

        for ($i=0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
        }
    }

    /**
    * roll the dices
    */
    public function roll()
    {
        $this->values = [];
        foreach ($this->dices as $value) {
            $this->values[] = $value->getDice();
        }
        return $this->values;
    }

    /**
    * get the sum of the rolled dices
    */
    public function sum()
    {
        return array_sum($this->values);
    }
}
