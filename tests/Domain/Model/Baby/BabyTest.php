<?php

namespace Pascualmg\Tests\Domain\Model\Baby;

use Pascualmg\biberro\Domain\Model\Baby\Baby;
use Pascualmg\biberro\Domain\Model\Baby\BabyCreatedDomainEvent;
use Pascualmg\biberro\Domain\Model\Baby\VO\BabyId;
use Pascualmg\biberro\Domain\Model\Baby\VO\BabyName;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertInstanceOf;

class BabyTest extends TestCase
{
    public function test_given_created_baby_when_pop_and_flush_events_then_i_have_created_event(){
        $Adel = Baby::create(BabyId::random(),  BabyName::from('Adel'));
        assertInstanceOf(BabyCreatedDomainEvent::class, $Adel->popAndFlushAllDomainEvents()[0]);
        assertInstanceOf(Baby::class, $Adel);

    }
}
