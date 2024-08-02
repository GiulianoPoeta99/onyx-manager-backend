<?php

namespace Modules\State\Models;

use CodeIgniter\Model;
use Modules\State\Entities\State;

class StateModel extends Model
{
    protected $table = 'state';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = State::class;
    protected $allowedFields = ['type_state_id', 'task_id', 'user_id'];

    protected $validationRules = [
        'type_state_id' => 'required|integer|is_not_unique[type_state.id]',
        'task_id' => 'required|integer|is_not_unique[task.id]',
        'user_id' => 'required|integer|is_not_unique[user.id]'
    ];

    protected $validationMessages = [
        'type_state_id' => [
            'required' => 'El ID del tipo de estado es obligatorio.',
            'integer' => 'El ID del tipo de estado debe ser un número entero.',
            'is_not_unique' => 'El tipo de estado especificada no existe.'
        ],
        'task_id' => [
            'required' => 'El ID de la tarea es obligatorio.',
            'integer' => 'El ID de la tarea debe ser un número entero.',
            'is_not_unique' => 'La tarea especificada no existe.'
        ],
        'user_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
            'is_not_unique' => 'El usuario especificado no existe.'
        ],
    ];

    protected $skipValidation = false;
}
