<?php

namespace Dostavista;

use Doctrine\Common\Inflector\Inflector;
use ReflectionClass;

abstract class AbstractModel implements Configurable, Exportable
{
    use ConfigureTrait;

    const DATE_TIMEZONE = 'Europe/Moscow';
    const DATE_EXPORT_FORMAT = 'Y-m-d H:i:s';

    public function __construct(array $config = [])
    {
        $this->configure($config);
    }

    public function export(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $reflectionProperties = $reflectionClass->getProperties();

        $result = [];
        foreach ($reflectionProperties as $reflectionProperty) {
            $propertyName = Inflector::tableize($reflectionProperty->getName());
            $customGetter = 'get' . ucfirst($propertyName);
            if (method_exists($this, $customGetter)) {
                $propertyValue = call_user_func([$this, $customGetter]);
            } else {
                $propertyValue = $this->{$reflectionProperty->getName()};
            }

            $propertyValue = $this->exportValue($propertyValue);

            if (is_array($propertyValue)) {
                $propertyName = Inflector::singularize($propertyName);
            }

            $result[$propertyName] = $propertyValue;
        }

        return $result;
    }

    protected function exportValue($propertyValue)
    {
        if (is_array($propertyValue)) {
            $buffer = [];
            foreach ($propertyValue as $item) {
                $buffer[] = $this->exportValue($item);
            }
            return $buffer;
        }

        if ($propertyValue instanceof Exportable) {
            return $propertyValue->export();
        }

        if ($propertyValue instanceof \DateTime) {
            $propertyValue->setTimezone(new \DateTimeZone(self::DATE_TIMEZONE));
            return $propertyValue->format(self::DATE_EXPORT_FORMAT);
        }

        return $propertyValue;
    }
}
