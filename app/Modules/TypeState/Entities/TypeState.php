<?php

namespace Modules\TypeState\Entities;

use CodeIgniter\Entity\Entity;

class TypeState extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'project_id' => 'integer',
        'type_activity_id' => 'integer',
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

    public function getTypeActivityId()
    {
        return $this->attributes['type_activity_id'];
    }

    public function setTypeActivityId(int $projectId)
    {
        $this->attributes['type_activity_id'] = $projectId;
    }
}
