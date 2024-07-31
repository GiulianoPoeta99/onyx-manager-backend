<?php

namespace Modules\Role\Entities;

use CodeIgniter\Entity\Entity;

class Role extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    public function setId(int $id)
    {
        $this->attributes['id'] = $id;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setName(string $name)
    {
        $this->attributes['name'] = $name;
    }
}
