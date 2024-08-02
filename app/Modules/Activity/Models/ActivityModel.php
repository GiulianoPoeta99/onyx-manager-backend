<?php

namespace Modules\Activity\Models;

use CodeIgniter\Model;
use Modules\Activity\Entities\Activity;

class ActivityModel extends Model
{
    protected $table = 'activity';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Activity::class;
    protected $allowedFields = ['name', 'project_id', 'type_activity_id', 'user_id'];

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'type_activity_id' => 'required|integer|is_not_unique[type_activity.id]',
        'project_id' => 'required|integer|is_not_unique[project.id]',
        'user_id' => 'required|integer|is_not_unique[project.id]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del proyecto es obligatorio.',
            'min_length' => 'El nombre del proyecto debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del proyecto no puede exceder los 255 caracteres.'
        ],
        'project_id' => [
            'required' => 'El ID del proyecto es obligatorio.',
            'integer' => 'El ID del proyecto debe ser un número entero.',
            'is_not_unique' => 'El proyecto especificado no existe.'
        ],
        'type_activity_id' => [
            'required' => 'El ID del tipo de actividad es obligatorio.',
            'integer' => 'El ID del tipo de actividad debe ser un número entero.',
            'is_not_unique' => 'El tipo de actividad especificado no existe.'
        ],
        'user_id' => [
            'required' => 'El ID del usuario es obligatorio.',
            'integer' => 'El ID del usuario debe ser un número entero.',
            'is_not_unique' => 'El usuario especificado no existe.'
        ],
    ];

    protected $skipValidation = false;
}
