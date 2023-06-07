<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class InvalidEmailDomainValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof InvalidEmailDomain) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\InvalidEmailDomain');
        }

        if ($value === null || $value === '') {
            return;
        }

        if (!is_scalar($value) && !(\is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedValueException($value, 'string');
        }

        $value = explode('@', (string) $value);

        if (isset($value[1]) && in_array($value[1], $constraint->domains)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setParameter('{{ domains }}', implode(', ', $constraint->domains))
                ->addViolation();
        }
    }
}
