<?php

namespace Modules\Task\Entities;

use CodeIgniter\Entity\Entity;

class Task extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'user_id' => 'integer',
        'activity_id' => 'integer',
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

    public function getUserId()
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function getActivityId()
    {
        return $this->attributes['activity_id'];
    }

    public function setActivityId(int $activityId)
    {
        $this->attributes['activity_id'] = $activityId;
    }
}
