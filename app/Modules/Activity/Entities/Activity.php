<?php

namespace Modules\Activity\Entities;

use CodeIgniter\Entity\Entity;

class Activity extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'project_id' => 'integer',
        'type_activity_id' => 'integer',
        'user_id' => 'integer',
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

    public function setTypeActivityId(int $typeActivityId)
    {
        $this->attributes['type_activity_id'] = $typeActivityId;
    }

    public function getUserId()
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $userId)
    {
        $this->attributes['user_id'] = $userId;
    }
}
