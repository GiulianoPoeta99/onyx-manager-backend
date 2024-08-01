<?php

namespace Modules\TypeActivity\Entities;

use CodeIgniter\Entity\Entity;

class TypeActivity extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'project_id' => 'integer',
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

    public function getProjectId()
    {
        return $this->attributes['project_id'];
    }

    public function setProjectId(int $projectId)
    {
        $this->attributes['project_id'] = $projectId;
    }
}
