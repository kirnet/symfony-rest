<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Validator\UniqueUserField;

use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserFieldValidator extends ConstraintValidator
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        $user = $this->userRepository->findBy([$constraint->field => $value]);
        if (!is_null($user)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation()
            ;
        }
    }
}