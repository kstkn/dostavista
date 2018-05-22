<?php

namespace Dostavista;

use Throwable;

class ValidationException extends \Exception
{
    /**
     * Validation context
     *
     * @var array
     */
    private $context;

    public function __construct(array $context, int $code = 0, Throwable $previous = null)
    {
        $this->context = $context;

        parent::__construct('Validation context: ' . json_encode($context), $code, $previous);
    }

    /**
     * Returns validation context
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
