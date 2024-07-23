<?php namespace Core\Entities;

use CodeIgniter\Entity\Entity;
use Core\Attributes\GetSet;
use ReflectionClass;

class BaseEntity extends Entity
{
    protected $dates = [];
    protected $casts = [];

    #[GetSet('get')]
    protected $id;

    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->initializeGettersAndSetters();
    }

    private function initializeGettersAndSetters()
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $attributes = $property->getAttributes(GetSet::class);
            if (!empty($attributes)) {
                $attribute = $attributes[0]->newInstance();
                $propertyName = $property->getName();

                if ($attribute->hasGetter()) {
                    $this->createGetter($propertyName);
                }
                if ($attribute->hasSetter()) {
                    $this->createSetter($propertyName);
                }
            }
        }
    }

    private function createGetter($property)
    {
        $methodName = 'get' . ucfirst($property);
        if (!method_exists($this, $methodName)) {
            $this->$methodName = function() use ($property) {
                return $this->attributes[$property] ?? null;
            };
        }
    }

    private function createSetter($property)
    {
        $methodName = 'set' . ucfirst($property);
        if (!method_exists($this, $methodName)) {
            $this->$methodName = function($value) use ($property) {
                $this->attributes[$property] = $value;
            };
        }
    }
}