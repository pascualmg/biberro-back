<?php

namespace Pascualmg\Tests\Domain\Model\Baby;

use Pascualmg\biberro\Domain\Model\Baby\Baby;
use Pascualmg\biberro\Domain\Model\Baby\BabyCreatedDomainEvent;
use Pascualmg\biberro\Domain\Model\Baby\VO\BabyId;
use Pascualmg\biberro\Domain\Model\Baby\VO\BabyName;
use Pascualmg\biberro\Infrastructure\Bus\MemEventBus;
use Pascualmg\dddfinitions\Domain\Bus\Event\DomainEvent;
use Pascualmg\dddfinitions\Domain\Bus\Event\DomainEventBus;
use Pascualmg\dddfinitions\Domain\Bus\Event\DomainEventSubscriber;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertInstanceOf;

class BabyTest extends TestCase
{
    private DomainEventBus $domainEventBus;

    public function test_given_created_baby_when_pop_and_flush_events_then_i_have_created_event()
    {
        $Adel = Baby::create(BabyId::random(), BabyName::from('Adel Muñoz Ruiz'));
        assertInstanceOf(BabyCreatedDomainEvent::class, $Adel->popAndFlushAllDomainEvents()[0]);
        assertInstanceOf(Baby::class, $Adel);
    }

    public function test_given_when_then()
    {
        $Adel = Baby::create(BabyId::random(), BabyName::from('Adel Muñoz Ruiz'));

        $dumper = new class implements DomainEventSubscriber {

            public bool $dispatched = false;

            public function subscribedToEvent(): array
            {
                return [BabyCreatedDomainEvent::class];
            }

            public function __invoke(DomainEvent $domainEvent)
            {
                $this->dispatched = true;
                dump($domainEvent);
            }
        };
        $this->domainEventBus->subscribe($dumper);
        $this->domainEventBus->dispatch(...$Adel->popAndFlushAllDomainEvents());


        self::assertTrue($dumper->dispatched);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->domainEventBus =  new MemEventBus();
    }
}
