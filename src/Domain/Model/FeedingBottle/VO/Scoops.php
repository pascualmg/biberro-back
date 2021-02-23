<?php


namespace Pascualmg\biberro\Domain\Model\FeedingBottle\VO;


use Pascualmg\dddfinitions\Domain\VO\IntValueObject;

class Scoops extends IntValueObject
{
    private const RATIO_SCOOP_ML = 30;

    public function toMililitres(): int
    {
        return self::RATIO_SCOOP_ML * $this->value();
    }

    public function toLitres(): float
    {
        return (self::RATIO_SCOOP_ML * $this->value()) / 1000;
    }

}