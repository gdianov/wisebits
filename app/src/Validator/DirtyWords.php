<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] final class DirtyWords extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Value contains forbidden words: {{ words }}';

    /**
     * @var string[]
     */
    public $words = ['pornohub'];

    /**
     * @return string
     */
    public function getDefaultOption()
    {
        return 'words';
    }
}
