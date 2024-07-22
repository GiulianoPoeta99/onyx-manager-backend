<?php namespace App\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class GetSet
{
    public function __construct(
        public ?string $access = null
    ) {}

    public function hasGetter(): bool
    {
        return $this->access === 'get' || $this->access === 'both' || $this->access === null;
    }

    public function hasSetter(): bool
    {
        return $this->access === 'set' || $this->access === 'both' || $this->access === null;
    }
}