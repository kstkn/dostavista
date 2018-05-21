<?php

namespace Dostavista;

use Throwable;

class ValidationException extends \Exception
{
    public function __construct(array $context, int $code = 0, Throwable $previous = null)
    {
        parent::__construct('Validation error(s): ' . json_encode($context), $code, $previous);
    }

}
