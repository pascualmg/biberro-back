<?php

namespace App\Tests\Domain\VO;

use App\Domain\VO\StringValueObject;
use PHPUnit\Framework\TestCase;

class StringValueObjectTest extends TestCase
{
    const MEANING_OF_EXISTENCE = 42;

    public function test_given_a_value_of_type_string_when_get_instance_using_from_then_value_is_stored_and_i_can_get_and_serialize(){
        $someStringWithVariableSize = random_bytes(random_int(1, self::MEANING_OF_EXISTENCE));

        $stringValueObject = StringValueObject::from($someStringWithVariableSize) ;

        self::assertEquals(
            expected: $someStringWithVariableSize,
            actual: $stringValueObject->value()
        );
        self::assertEquals(
            expected: $someStringWithVariableSize,
            actual: $stringValueObject->JsonSerialize()
        );
    }

    public function test_given_a_value_with_the_meaing_of_existence_type_when_get_instance_using_from_then_trhows_exception_and_tell_me_the_wrong_type_used(){
        $this->expectException('Exception');
        StringValueObject::from(self::MEANING_OF_EXISTENCE);
    }
}
