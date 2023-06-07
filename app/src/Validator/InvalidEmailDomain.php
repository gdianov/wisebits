<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] final class InvalidEmailDomain extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Value contains invalid email domain: {{ domains }}';

    /**
     * @var string[]
     */
    public $domains = ['yahoo.com'];

    /**
     * @return string
     */
    public function getDefaultOption()
    {
        return 'domains';
    }
}
