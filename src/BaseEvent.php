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
     * @var int Order ID
     */
    protected $signature;

    /**
     * @var array Event data
     */
    protected $data;

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