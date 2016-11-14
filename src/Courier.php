<?php

namespace Dostavista;

class Courier extends AbstractModel
{
    /**
     * @var string Phone number, 10 digits without starting "8".
     */
    protected $phone;

    /**
     * @var string Courier name.
     */
    protected $name;

    /**
     * @var string URI to courier photo.
     */
    protected $photo;

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }
}