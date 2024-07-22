<?php namespace Modules\User\Entities;

use Core\Entities\BaseEntity;
use Core\Attributes\GetSet;

class UserEntity extends BaseEntity
{
    #[GetSet]
    protected $id;

    #[GetSet]
    protected $email;

    #[GetSet('get')]
    protected $password;

    #[GetSet]
    protected $first_name;

    #[GetSet]
    protected $last_name;

    public function setPassword(string $password): self
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}