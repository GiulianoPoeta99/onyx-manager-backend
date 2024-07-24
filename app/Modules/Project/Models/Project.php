<?php namespace Modules\Project\Models;

use Core\Models\BaseModel;

use Modules\Project\Entities\ProjectEntity;

class Project extends BaseModel
{
    protected $table = 'project';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ProjectEntity::class;
    protected $allowedFields = ['name', 'user_id'];

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'user_id' => 'required|integer|is_not_unique[user.id]'
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
        ]
    ];

    protected $skipValidation = false;
}