<?php namespace Core\Entities;

use CodeIgniter\Entity\Entity;

use Core\Attributes\GetSet;

class BaseEntity extends Entity
{
    protected $dates = [];
    protected $casts = [];

    public function __get($key)
    {
        $getter = $this->getAccessorMethod($key, 'get');
        if ($getter) {
            return $this->$getter();
        }
        return parent::__get($key);
    }

    public function __set(string $key, $value = null)
    {
        $setter = $this->getAccessorMethod($key, 'set');
        if ($setter) {
            $this->$setter($value);
        } else {
            parent::__set($key, $value);
        }
    }

    private function getAccessorMethod($property, $type)
    {
        $reflection = new \ReflectionClass($this);
        $props = $reflection->getProperties();

        foreach ($props as $prop) {
            $attributes = $prop->getAttributes(GetSet::class);
            if (!empty($attributes) && $prop->getName() === $property) {
                $attribute = $attributes[0]->newInstance();
                
                if ($type === 'get' && $attribute->hasGetter()) {
                    return 'get' . ucfirst($property);
                } elseif ($type === 'set' && $attribute->hasSetter()) {
                    return 'set' . ucfirst($property);
                }
                
                return null;
            }
        }

        return null;
    }
}