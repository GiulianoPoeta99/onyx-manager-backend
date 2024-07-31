<?php

namespace Modules\Role\Models;

use CodeIgniter\Model;
use Modules\Role\Entities\Role;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Role::class;
    protected $allowedFields = ['name']; // Completar con los campos permitidos

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del proyecto es obligatorio.',
            'min_length' => 'El nombre del proyecto debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del proyecto no puede exceder los 255 caracteres.'
        ],
    ];

    protected $skipValidation = false;
}
