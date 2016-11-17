<?php

namespace Dostavista;

class BaseEvent extends AbstractModel
{
    /**
     * Order changed
     */
    const EVENT_ORDER_CHANGED = 'order_changed';

    /**
     * @var string Event type
     */
    protected $event;

    /**
     * @var string Signature
     */
    protected $signature;

    /**
     * @var array Event data
     */
    protected $data;

    public function __construct(string $event, string $signature, array $data)
    {
        parent::__construct();
        $this->event = $event;
        $this->signature = $signature;
        $this->data = $data;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function asArray(): array
    {
        return [
            'event' => $this->event,
            'signature' => '',
            'data' => $this->data,
        ];
    }
}