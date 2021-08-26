<?php

namespace Pascualmg\biberro\Infrastructure\Bus;

use Pascualmg\dddfinitions\Domain\Bus\Event\DomainEvent;
use Pascualmg\dddfinitions\Domain\Bus\Event\DomainEventBus;
use Pascualmg\dddfinitions\Domain\Bus\Event\DomainEventSubscriber;

class MemEventBus implements DomainEventBus
{
    /** @var array DomainEventSubscriber */
    private array $subscribers;

    public function __construct(DomainEventSubscriber ...$subscribers)
    {
        $this->subscribers = $subscribers;
    }


    public function dispatch(DomainEvent ...$domainEvents): void
    {
        function feach(iterable $list, callable $fn): void
        {
            foreach ($list as $item) {
                $fn($item);
            }
        }

        feach(
            $domainEvents,
            fn(DomainEvent $domainEvent) => feach(
                array_filter(
                    $this->subscribers,
                    static fn(DomainEventSubscriber $subscriber) => in_array(
                        $domainEvent::class,
                        $subscriber->subscribedToEvent()
                    )
                ),
                fn(DomainEventSubscriber $subscriberToDispatch) => $subscriberToDispatch($domainEvent)
            )
        );
    }

    public function subscribe(DomainEventSubscriber ...$domainEventSubscribers): void
    {
        $this->subscribers = array_merge($this->subscribers, $domainEventSubscribers);
    }
}