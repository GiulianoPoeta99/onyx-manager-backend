<?php

namespace Modules\Audit\Models;

use CodeIgniter\Model;
use Modules\Audit\Entities\Audit;

class AuditModel extends Model
{
    protected $table = 'audit';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Audit::class;
    protected $allowedFields = ['action', 'table', 'table_id', 'old_content', 'new_content', 'change_date'];

    protected $validationRules = [
        'action'      => 'required|max_length[50]',
        'table'       => 'required|max_length[100]',
        'table_id'    => 'required|numeric',
        'old_content' => 'permit_empty',
        'new_content' => 'permit_empty',
        'change_date' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'action' => [
            'required' => 'La acción es requerida.',
            'max_length' => 'La acción no puede exceder los 50 caracteres.'
        ],
        'table' => [
            'required' => 'El nombre de la tabla es requerido.',
            'max_length' => 'El nombre de la tabla no puede exceder los 100 caracteres.'
        ],
        'table_id' => [
            'required' => 'El ID de la tabla es requerido.',
            'numeric' => 'El ID de la tabla debe ser un número.'
        ],
        'change_date' => [
            'required' => 'La fecha de cambio es requerida.',
            'valid_date' => 'La fecha de cambio debe ser una fecha válida.'
        ]
    ];

    protected $skipValidation = false;
}
