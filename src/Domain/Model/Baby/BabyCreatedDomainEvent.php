<?php


namespace App\Domain\Model\Baby;


use App\Domain\Model\Baby\VO\BabyName;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
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

    #[Pure] #[ArrayShape(['id' => "string", 'name' => "string"])]
    public function toPrimitives(): array
    {
        return [
            'id' => $this->aggregateId(),
            'name' => (string)$this->babyName,
        ];
    }
}