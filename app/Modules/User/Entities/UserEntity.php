<?php namespace Modules\User\Entities;

use Core\Entities\BaseEntity;
use Core\Attributes\GetSet;

class UserEntity extends BaseEntity
{
    protected $casts = [
        'id' => 'integer',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
    ];

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
}