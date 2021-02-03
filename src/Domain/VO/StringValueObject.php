<?php


namespace App\Domain\VO;

class StringValueObject extends ValueObject
{
    protected function assertValueOrThrowException($value): void
    {
        if (is_string($value)) {
            return;
        }
        throw new \Exception('Error : StringValueObject from not string! used : ' . gettype($value));
    }
}