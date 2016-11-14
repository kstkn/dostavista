<?php

namespace Dostavista;

use DateTime;

class Order extends BaseOrder
{
    /**
     * Order was received by service, available for dispatcher, couriers can't see order.
     */
    const STATUS_NEW = 0;

    /**
     * Order is published, available for couriers to see.
     */
    const STATUS_OPEN = 1;

    /**
     * Courier assigned.
     */
    const STATUS_ACTIVE = 2;

    /**
     * Order was finished.
     */
    const STATUS_FINISHED = 3;

    /**
     * Order was canceled.
     */
    const STATUS_CANCELED = 10;

    /**
     * Awaiting clarification from client.
     */
    const STATUS_POSTPONED = 16;

    /**
     * @var int Dostavista order number
     */
    protected $orderId;

    /**
     * @var int Order status. See STATUS_* constants.
     */
    protected $status;

    /**
     * @var string Status name
     */
    protected $statusName;

    /**
     * @var DateTime Order creation date & time
     */
    protected $created;

    /**
     * @var float Full delivery cost
     */
    protected $cost;

    /**
     * @var float Insurance fee
     */
    protected $insuranceFee;

    /**
     * @var float Fee for receiving money from customer
     */
    protected $takingTransferFee;

    /**
     * @var float Weight fee
     */
    protected $weightFee;

    /**
     * @var int
     */
    protected $smsNotification;

    /**
     * @var int
     */
    protected $backpaymentAmount;

    /**
     * @var float
     */
    protected $deliveryFee;

    /**
     * @var float
     */
    protected $payment;

    /**
     * @var Courier
     */
    protected $courier = [];

    protected function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    protected function setStatus(int $status)
    {
        $this->status = $status;
    }

    protected function setCreated(string $time)
    {
        $this->created = new DateTime($time);
    }

    protected function setCost(float $cost)
    {
        $this->cost = $cost;
    }

    protected function setInsuranceFee(float $insuranceFee)
    {
        $this->insuranceFee = $insuranceFee;
    }

    protected function setTakingTransferFee(float $takingTransferFee)
    {
        $this->takingTransferFee = $takingTransferFee;
    }

    protected function setWeightFee(float $weightFee)
    {
        $this->weightFee = $weightFee;
    }

    protected function setCourier($courier)
    {
        if (!$courier instanceof Courier) {
            $courier = new Courier($courier);
        }

        $this->courier = $courier;
    }

    protected function setSmsNotification(int $smsNotification)
    {
        $this->smsNotification = $smsNotification;
    }

    protected function setBackpaymentAmount(float $backpaymentAmount)
    {
        $this->backpaymentAmount = $backpaymentAmount;
    }

    protected function setDeliveryFee(float $deliveryFee)
    {
        $this->deliveryFee = $deliveryFee;
    }

    protected function setPayment(float $payment)
    {
        $this->payment = $payment;
    }

    protected function setRequireCar(int $requireCar)
    {
        $this->requireCar = $requireCar;
    }

    protected function setInsurance(float $insurance)
    {
        $this->insurance = $insurance;
    }

    protected function setBackpaymentMethod(int $backpaymentMethod)
    {
        $this->backpaymentMethod = $backpaymentMethod;
    }

    protected function setRecipientsSmsNotification(int $recipientsSmsNotification)
    {
        $this->recipientsSmsNotification = $recipientsSmsNotification;
    }

    protected function setRequireLoading(int $requireLoading)
    {
        $this->requireLoading = $requireLoading;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return Point[]
     */
    public function getPoints()
    {
        return $this->points;
    }
}