<?php namespace Core\Models;

use CodeIgniter\Model;

use Core\Entities\BaseEntity;

class BaseModel extends Model
{
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = BaseEntity::class;
    protected $allowedFields = [];
}