<?php

namespace Modules\Task\Models;

use CodeIgniter\Model;
use Modules\Task\Entities\Task;

class TaskModel extends Model
{
    protected $table = 'task';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Task::class;
    protected $allowedFields = ['name', 'activity_id', 'user_id'];

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'user_id' => 'required|integer|is_not_unique[user.id]',
        'activity_id' => 'required|integer|is_not_unique[type_activity.id]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del proyecto es obligatorio.',
            'min_length' => 'El nombre del proyecto debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del proyecto no puede exceder los 255 caracteres.'
        ],
        'user_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
            'is_not_unique' => 'El usuario especificado no existe.'
        ],
        'activity_id' => [
            'required' => 'El ID de la actividad es obligatorio.',
            'integer' => 'El ID de la actividad debe ser un número entero.',
            'is_not_unique' => 'La actividad especificada no existe.'
        ]
    ];

    protected $skipValidation = false;
}
