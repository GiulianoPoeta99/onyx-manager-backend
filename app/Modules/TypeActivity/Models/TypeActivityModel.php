<?php

namespace Modules\TypeActivity\Models;

use CodeIgniter\Model;
use Modules\TypeActivity\Entities\TypeActivity;

class TypeActivityModel extends Model
{
    protected $table = 'type_activity';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = TypeActivity::class;
    protected $allowedFields = ['name', 'project_id'];

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'project_id' => 'required|integer|is_not_unique[project.id]'
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
        ]
    ];

    protected $skipValidation = false;
}
