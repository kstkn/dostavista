<?php

namespace Dostavista;

class CancelRequest extends AbstractModel
{
    /**
     * Courier was not found by service
     */
    const SUBSTATUS_COURIER_NOT_FOUND = 1;

    /**
     * Order is not needed anymore
     */
    const SUBSTATUS_NOT_NEEDED = 3;

    /**
     * Address was included into different order
     */
    const SUBSTATUS_CONSUMED_BY_ORDER = 4;

    /**
     * @var int Order ID
     */
    protected $orderId;

    /**
     * @var int|null Cancel reason. See SUBSTATUS_* constants
     */
    protected $substatusId;

    /**
     * CancelRequest constructor.
     * @param int $orderId Order ID
     * @param int $substatusId Cancel reason. See SUBSTATUS_* constants
     */
    public function __construct(int $orderId, $substatusId = null)
    {
        parent::__construct();
        $this->orderId = $orderId;
        $this->substatusId = $substatusId;
    }
}