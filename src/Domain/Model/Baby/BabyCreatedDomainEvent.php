<?php


namespace Pascualmg\biberro\Domain\Model\Baby;


use Pascualmg\biberro\Domain\Model\Baby\VO\BabyName;
use pascualmg\dddfinitions\Domain\Bus\Event\DomainEvent;

class BabyCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        private BabyName $babyName,
        string $aggregateId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $payload,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($payload['babyName'], $aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'baby.created';
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->aggregateId(),
            'name' => (string)$this->babyName,
        ];
    }
}