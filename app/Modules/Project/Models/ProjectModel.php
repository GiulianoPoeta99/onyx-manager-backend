<?php

namespace Modules\Project\Models;

use CodeIgniter\Model;
use Modules\Project\Entities\Project;

class ProjectModel extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Project::class;
    protected $allowedFields = ['name', 'user_id'];

    protected $validationRules = [
        'id' => 'required|is_natural_no_zero',
        'name' => 'required|min_length[3]|max_length[255]',
        'user_id' => 'required|integer|is_not_unique[user.id]'
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'El campo ID es obligatorio.',
            'is_natural_no_zero' => 'El campo ID debe ser un número natural mayor que cero.'
        ],
        'name' => [
            'required' => 'El nombre del proyecto es obligatorio.',
            'min_length' => 'El nombre del proyecto debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del proyecto no puede exceder los 255 caracteres.'
        ],
        'user_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
            'is_not_unique' => 'El usuario especificado no existe.'
        ]
    ];

    protected $skipValidation = false;
}
