<?php

namespace Modules\UserProject\Entities;

use CodeIgniter\Entity\Entity;

class UserProject extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'project_id' => 'integer',
    ];

    public function setId($id)
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    public function setUserId($userId)
    {
        $this->attributes['user_id'] = $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->attributes['user_id'];
    }

    public function setProjectId($projectId)
    {
        $this->attributes['project_id'] = $projectId;
        return $this;
    }

    public function getProjectId()
    {
        return $this->attributes['project_id'];
    }
}
