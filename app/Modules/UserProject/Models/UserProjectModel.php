<?php

namespace Modules\UserProject\Models;

use CodeIgniter\Model;
use Modules\UserProject\Entities\UserProject;

class UserProjectModel extends Model
{
    protected $table = 'user_project';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = UserProject::class;
    protected $allowedFields = ['user_id', 'project_id']; // Campos permitidos

    protected $validationRules = [
        'user_id' => 'required|integer|is_not_unique[user.id]',
        'project_id' => 'required|integer|is_not_unique[project.id]'
    ];
    protected $validationMessages = [
        'user_id' => [
            'required' => 'El ID de usuario es requerido.',
            'integer' => 'El ID de usuario debe ser un número entero.',
            'is_not_unique' => 'El usuario especificado no existe.'
        ],
        'project_id' => [
            'required' => 'El ID de proyecto es requerido.',
            'integer' => 'El ID de proyecto debe ser un número entero.',
            'is_not_unique' => 'El proyecto especificado no existe.'
        ]
    ];
    protected $skipValidation = false;
}
