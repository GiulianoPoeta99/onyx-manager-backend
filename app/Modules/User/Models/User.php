<?php namespace Modules\User\Models;

use Core\Models\BaseModel;
use Modules\User\Entities\UserEntity;

class User extends BaseModel
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = UserEntity::class;
    protected $allowedFields = ['email', 'password', 'first_name', 'last_name'];

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[user.email,id,{id}]',
        'password' => 'required|min_length[8]',
        'first_name' => 'required|alpha_space|min_length[2]',
        'last_name' => 'required|alpha_space|min_length[2]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Este email ya está registrado.'
        ]
    ];

    protected $skipValidation = false;
}