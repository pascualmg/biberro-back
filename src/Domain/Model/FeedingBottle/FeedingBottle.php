<?php


namespace pascualmg\biberro\Domain\Model\FeedingBottle;


use Pascualmg\biberro\Domain\Model\Baby\VO\BabyId;
use Pascualmg\biberro\Domain\Model\FeedingBottle\VO\FeedingBottleId;
use Pascualmg\biberro\Domain\Model\FeedingBottle\VO\Scoops;
use pascualmg\dddfinitions\Domain\Entity;
use pascualmg\dddfinitions\Domain\VO\AtomDate;
use pascualmg\dddfinitions\Domain\VO\Uuid;

class FeedingBottle extends Entity
{
    private function __construct(
        private BabyId $babyId,
        private Scoops $scoops,
        private ?AtomDate $drunkOn = null,
        private ?FeedingBottleId $id = null
    ) {
        $this->drunkOn ?? AtomDate::now();
        $this->id ?? Uuid::random();
    }

    public static function create(BabyId $babyId, Scoops $scoops): self
    {
        return new self(
            $babyId,
            $scoops
        );
    }

    public static function from(BabyId $babyId, Scoops $scoops, AtomDate $drinkedOn, FeedingBottleId $id): self
    {
        return new self(
            $babyId,
            $scoops,
            $drinkedOn,
            $id
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function babyId(): BabyId
    {
        return $this->babyId;
    }

    public function scoops(): Scoops
    {
        return $this->scoops;
    }

    public function drunkOn(): AtomDate
    {
        return $this->drunkOn;
    }

    public function getId(): FeedingBottleId
    {
        return $this->id;
    }

    public static function name(): string
    {
        return 'feedingbottle';
    }

    public function jsonSerialize()
    {
        return [
            'babyId' => $this->babyId()->value(),
            'mililitres' => $this->scoops()->toMililitres(),
            'drunkOn' => $this->drunkOn()->value(),
        ];
    }
}