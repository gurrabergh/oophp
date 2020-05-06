<?php

namespace GB\Dice;

trait HistogramTrait
{

    private $serie = [];


    public function getHistogramSerie()
    {
        return $this->serie;
    }


    public function getHistogramMin()
    {
        return 1;
    }

    public function getHistogramMax()
    {
        return max($this->serie);
    }
}
