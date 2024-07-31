<?php

namespace Modules\UserRole\Entities;

use CodeIgniter\Entity\Entity;

class UserRole extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'role_id' => 'integer',
    ];

    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    public function setId(int $id)
    {
        $this->attributes['id'] = $id;
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

    public function setRoleId($roleId)
    {
        $this->attributes['role_id'] = $roleId;
        return $this;
    }

    public function getRoleId()
    {
        return $this->attributes['role_id'];
    }
}
