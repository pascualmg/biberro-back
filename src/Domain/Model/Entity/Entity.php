<?php


namespace App\Domain\Model\Entity;
use App\Domain\VO\ValueObject;
use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    abstract public function id(): ValueObject;
}