<?php

namespace Modules\State\Entities;

use CodeIgniter\Entity\Entity;

class State extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'type_state_id' => 'integer',
        'task_id' => 'integer',
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

    public function getTypeStateId()
    {
        return $this->attributes['type_state_id'];
    }

    public function setTypeStateId(int $typeState)
    {
        $this->attributes['type_state_id'] = $typeState;
    }

    public function getTaskId()
    {
        return $this->attributes['task_id'];
    }

    public function setTaskId(int $taskId)
    {
        $this->attributes['task_id'] = $taskId;
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
