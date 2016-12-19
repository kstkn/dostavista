<?php

namespace Dostavista;

use DateTime;

class Point extends AbstractModel
{
    /**
     * @var string Address point
     */
    protected $address;

    /**
     * @var string Address details
     */
    protected $note;

    /**
     * @var DateTime The earliest time to arrive to this point
     */
    protected $requiredTimeStart;

    /**
     * @var DateTime The latest time to arrive to this point
     */
    protected $requiredTime;

    /**
     * @var string The name of contact person
     */
    protected $contactPerson;

    /**
     * @var string 10 digits of contact phone number
     */
    protected $phone;

    /**
     * @var int
     */
    protected $taking;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @var string
     */
    protected $clientOrderId;

    /**
     * @var int
     */
    protected $inOutline;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    public function __construct(string $address, DateTime $requiredTimeStart, DateTime $requiredTime, string $phone, array $config = [])
    {
        parent::__construct($config);
        $this->address = $address;
        $this->requiredTimeStart = $requiredTimeStart;
        $this->requiredTime = $requiredTime;
        $this->phone = $phone;

    }

    /**
     * @param string $contactPerson
     *
     * @return self
     */
    public function setContactPerson(string $contactPerson): self
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    /**
     * @param string $note
     *
     * @return self
     */
    public function setNote(string $note): self
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @param float $taking
     *
     * @return self
     */
    public function setTaking(float $taking): self
    {
        $this->taking = $taking;
        return $this;
    }

    /**
     * @param int $weight
     *
     * @return self
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @param string $clientOrderId
     *
     * @return self
     */
    public function setClientOrderId(string $clientOrderId): self
    {
        $this->clientOrderId = $clientOrderId;
        return $this;
    }

    protected function setContactPersone(string $contactPersone)
    {
        $this->contactPerson = $contactPersone;
    }

    protected function setInOutline(int $inOutline)
    {
        $this->inOutline = $inOutline;
    }

    protected function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    protected function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }
}