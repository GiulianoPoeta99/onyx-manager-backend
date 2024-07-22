<?php namespace App\Core\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [];

    private function getAccessorMethod($property, $type)
    {
        $reflection = new ReflectionClass($this);
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

    public function __get($name)
    {
        $getter = $this->getAccessorMethod($name, 'get');
        if ($getter) {
            return $this->$getter();
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        $setter = $this->getAccessorMethod($name, 'set');
        if ($setter) {
            $this->$setter($value);
        } else {
            parent::__set($name, $value);
        }
    }
}