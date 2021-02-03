<?php


namespace App\Domain\VO;

class IntValueObject extends ValueObject
{

    public static function fromString(string $number): IntValueObject
    {
        return self::from((int)$number);
    }

    protected function assertValueOrThrowException($value): void
    {
        if (is_integer($value)) {
            return;
        }
        throw new \Exception('Bad type !! IntValueObject from wrong type : ' . gettype($value));
    }
}