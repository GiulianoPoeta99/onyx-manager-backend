<?php

namespace Modules\UserRole\Models;

use CodeIgniter\Model;
use Modules\UserRole\Entities\UserRole;

class UserRoleModel extends Model
{
    protected $table = 'user_role';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = UserRole::class;
    protected $allowedFields = ['user_id', 'role_id'];

    protected $validationRules = [
        'user_id' => 'required|integer|is_not_unique[user.id]',
        'role_id' => 'required|integer|is_not_unique[project.id]'
    ];
    protected $validationMessages = [
        'user_id' => [
            'required' => 'El ID de usuario es requerido.',
            'integer' => 'El ID de usuario debe ser un número entero.',
            'is_not_unique' => 'El usuario especificado no existe.'
        ],
        'role_id' => [
            'required' => 'El ID del rol es requerido.',
            'integer' => 'El ID del rol debe ser un número entero.',
            'is_not_unique' => 'El rol especificado no existe.'
        ]
    ];

    protected $skipValidation = false;
}
