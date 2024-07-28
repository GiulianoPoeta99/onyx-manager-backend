<?php

namespace Modules\User\Models;

use CodeIgniter\Model;
use Modules\User\Entities\User;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = User::class;
    protected $allowedFields = ['email', 'password', 'first_name', 'last_name'];

    protected $validationRules = [
        'id' => 'required|is_natural_no_zero',
        'email' => 'required|valid_email|is_unique[user.email,id,{id}]',
        'password' => 'required|min_length[8]',
        'first_name' => 'required|alpha_space|min_length[2]',
        'last_name' => 'required|alpha_space|min_length[2]'
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'El campo ID es obligatorio.',
            'is_natural_no_zero' => 'El campo ID debe ser un número natural mayor que cero.'
        ],
        'email' => [
            'is_unique' => 'Este email ya está registrado.'
        ]
    ];

    protected $skipValidation = false;
}
