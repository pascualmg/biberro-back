<?php


namespace App\Domain\Model\Baby;


use App\Domain\Model\Baby\VO\BabyId;
use App\Domain\Model\Baby\VO\BabyName;
use App\Domain\Model\FeedingBottle\FeedingBottle;
use pascualmg\dddfinitions\Domain\AggregateRoot;

final class Baby extends AggregateRoot
{
    private function __construct(
        private BabyId $babyId,
        private BabyName $babyName
    ) {
    }

    public static function create(BabyId $babyId, BabyName $babyName)
    {
        $self = new self($babyId, $babyName);
        $self->pushDomainEvent(
            new BabyCreatedDomainEvent($self->babyName(), $self->id())
        );
        return $self;
    }


    public function babyName(): BabyName
    {
        return $this->babyName;
    }

    public function drink(FeedingBottle $feedingBottle): void
    {
        $this->pushDomainEvent(
            new BabyDrunkOneFeedingBottle(
                $this->id(),
                $feedingBottle->scoops()->toMililitres(),
                null,
                (string)$feedingBottle->drunkOn()
            )
        );
    }

    public function id(): BabyId
    {
        return $this->babyId;
    }

    public static function name(): string
    {
        return 'baby';
    }
}