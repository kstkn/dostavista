<?php

namespace Dostavista;

class OrderRequest extends BaseOrder
{
    public function __construct(string $matter, array $config = [])
    {
        parent::__construct($config);
        $this->setMatter($matter);
    }

    /**
     * @param int $requireCar See DELIVERY_TYPE_* constants
     *
     * @return $this
     */
    public function setRequireCar(int $requireCar)
    {
        $this->requireCar = $requireCar;
        return $this;
    }

    /**
     * @param string $matter
     *
     * @return $this
     */
    public function setMatter(string $matter)
    {
        $this->matter = $matter;
        return $this;
    }

    /**
     * @param int $insurance
     *
     * @return $this
     */
    public function setInsurance(int $insurance)
    {
        $this->insurance = $insurance;
        return $this;
    }

    /**
     * @param int $backpaymentMethod
     *
     * @return $this
     */
    public function setBackpaymentMethod(int $backpaymentMethod)
    {
        $this->backpaymentMethod = $backpaymentMethod;
        return $this;
    }

    /**
     * @param string $backpaymentDetails
     *
     * @return $this
     */
    public function setBackpaymentDetails(string $backpaymentDetails)
    {
        $this->backpaymentDetails = $backpaymentDetails;
        return $this;
    }

    /**
     * @param string $bapiUserAgent
     *
     * @return $this
     */
    public function setBapiUserAgent(string $bapiUserAgent)
    {
        $this->bapiUserAgent = $bapiUserAgent;
        return $this;
    }

    /**
     * @param bool $recipientsSmsNotification
     *
     * @return $this
     */
    public function setRecipientsSmsNotification(bool $recipientsSmsNotification)
    {
        $this->recipientsSmsNotification = $recipientsSmsNotification;
        return $this;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setNote(string $text)
    {
        $this->note = $text;
        return $this;
    }
}