<?php

namespace App\Tests\Domain\VO;

use App\Domain\VO\IntValueObject;
use App\Domain\VO\StringValueObject;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class IntValueObjectTest extends TestCase
{
    public function test_given_when_then()
    {
        $foo =IntValueObject::fromString("42");
        $foo->JsonSerialize();
        assertEquals(42, $foo->value());
    }

    public function test_given_when_then_2()
    {
        $bar =IntValueObject::from(42);
        $bar->JsonSerialize();
        assertEquals(42, $bar->value());
    }

    public function test_given_when_then_3()
    {
        $foo =IntValueObject::fromString("42");
        $bar =StringValueObject::from("42");

        $this->assertFalse($bar->equals($foo));
    }



}
