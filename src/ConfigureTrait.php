<?php

namespace Dostavista;

use Doctrine\Common\Inflector\Inflector;

trait ConfigureTrait
{
    public function configure(array $config)
    {
        foreach ($config as $key => $value) {
            $propertyName = Inflector::camelize($key);
            $customSetter = 'set' . ucfirst($propertyName);
            if (method_exists($this, $customSetter)) {
                call_user_func([$this, $customSetter], $value);
                continue;
            }

            if (property_exists($this, $propertyName)) {
                $this->{$propertyName} = $value;
            }
        }
    }
}