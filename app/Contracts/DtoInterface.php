<?php

namespace App\Contracts;

interface DtoInterface
{
    public static function fromArray(array $data): self;
    public function toArray(): array;
}