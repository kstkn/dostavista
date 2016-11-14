<?php

namespace Dostavista;

use DateTime;

abstract class BaseOrder extends AbstractModel
{
    /**
     * On foot (<=15kg)
     */
    const DELIVERY_TYPE_FOOT = 0;

    /**
     * Passenger car (<=200kg)
     */
    const DELIVERY_TYPE_CAR = 1;

    /**
     * Truck
     */
    const DELIVERY_TYPE_TRUCK = 2;

    /**
     * Online wallet payment
     */
    const BACKPAYMENT_ONLINE = 1;

    /**
     * Transfer to the bank card
     */
    const BACKPAYMENT_CARD = 2;

    /**
     * Buyout buy a courier
     */
    const BACKPAYMENT_BUYOUT = 3;

    /**
     * @var int See DELIVERY_TYPE_* constants.
     */
    protected $requireCar;

    /**
     * @var string Shipment description
     */
    protected $matter;

    /**
     * @var int Insurance size
     */
    protected $insurance;

    /**
     * @var int See BACKPAYMENT_* constants
     */
    protected $backpaymentMethod;

    /**
     * @var string Backpayment additional info (online wallet ID, bank card PAN, ...)
     */
    protected $backpaymentDetails;

    /**
     * @var string See API reference for details
     */
    protected $bapiUserAgent;

    /**
     * @var bool Whether to send or not SMS notification for recipient
     */
    protected $recipientsSmsNotification;

    /**
     * @var int
     */
    protected $requireLoading;

    /**
     * @var string
     */
    protected $note;

    /**
     * @var Point[]
     */
    protected $points = [];

    /**
     * @param Point[]|array $points
     *
     * @return $this
     */
    public function setPoints(array $points)
    {
        foreach ($points as &$point) {
            if (!$point instanceof Point) {
                $point = new Point($point['address'], new DateTime($point['required_time_start']), new DateTime($point['required_time']), $point['phone'], $point);
            }
        }

        $this->points = $points;
        return $this;
    }
}