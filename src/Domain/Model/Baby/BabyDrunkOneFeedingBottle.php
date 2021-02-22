<?php


namespace App\Domain\Model\Baby;


use pascualmg\dddfinitions\Domain\Bus\Event\DomainEvent;

class BabyDrunkOneFeedingBottle extends DomainEvent
{
    public function __construct(string $babyId, private int $amount, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct(
            $babyId,
            $eventId,
            $occurredOn
        );
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $payload,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $payload['amount'],
            $eventId,
            $occurredOn,
        );
    }

    public static function eventName(): string
    {
        return 'baby.drunk.one.feedingbottle';
    }

    public function toPrimitives(): array
    {
        return [
            'amount' => $this->amount
        ];
    }
}