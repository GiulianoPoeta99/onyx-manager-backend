<?php namespace Modules\Project\Entities;

use Core\Entities\BaseEntity;
use Core\Attributes\GetSet;

class ProjectEntity extends BaseEntity
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'user_id' => 'integer',
    ];

    #[GetSet]
    protected $name;

    #[GetSet]
    protected $user_id;
}