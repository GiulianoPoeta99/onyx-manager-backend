<?php

namespace Modules\User\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
    ];

    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    public function setId(int $id)
    {
        $this->attributes['id'] = $id;
    }

    public function getEmail()
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email)
    {
        $this->attributes['email'] = $email;
    }

    public function setPassword(string $password): self
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getPassword()
    {
        return $this->attributes['password'];
    }

    public function getFirstName()
    {
        return $this->attributes['first_name'];
    }

    public function setFirstName(string $firstName)
    {
        $this->attributes['first_name'] = $firstName;
    }

    public function getLastName()
    {
        return $this->attributes['last_name'];
    }

    public function setLastName(string $lastName)
    {
        $this->attributes['last_name'] = $lastName;
    }
}
