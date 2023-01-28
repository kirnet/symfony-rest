<?php

namespace App\Shared\Domain\ValueObject;

class GlobalUserId
{
    private string $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
