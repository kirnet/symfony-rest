<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Validator\UniqueUserField\Constraint;

use App\Users\Infrastructure\Validator\UniqueUserField\UniqueUserFieldValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueUserField extends Constraint
{
    public function __construct(
        public string $field,
        public string $message = '"{{ string }}" already exists',
        array $groups = null,
        mixed $payload = null
    )
    {
        parent::__construct([], $groups, $payload);
    }

    public function validatedBy(): string
    {
        return UniqueUserFieldValidator::class;
    }
}