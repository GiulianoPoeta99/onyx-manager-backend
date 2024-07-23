<?php namespace Modules\User\Entities;

use Core\Entities\BaseEntity;
use Core\Attributes\GetSet;

class UserEntity extends BaseEntity
{
    protected $dates = ['change_date', 'created_at', 'updated_at', 'deleted_at'];
    
    protected $casts = [
        'id' => 'integer',
        'table_id' => 'integer',
        'old_content' => 'json',
        'new_content' => 'json',
        'change_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    #[GetSet('set')]
    protected $action;
    
    #[GetSet('set')]
    protected $table;
    
    #[GetSet('set')]
    protected $table_id;
    
    #[GetSet('set')]
    protected $old_content;
    
    #[GetSet('set')]
    protected $new_content;
    
    #[GetSet('set')]
    protected $change_date;

    public function getDiff(): array
    {
        $old = json_decode($this->old_content, true) ?? [];
        $new = json_decode($this->new_content, true) ?? [];
        
        $diff = [];
        foreach ($new as $key => $value) {
            if (!isset($old[$key]) || $old[$key] !== $value) {
                $diff[$key] = [
                    'old' => $old[$key] ?? null,
                    'new' => $value
                ];
            }
        }
        
        return $diff;
    }

    public function getChangeSummary(): string
    {
        $diff = $this->getDiff();
        $changes = [];
        foreach ($diff as $field => $values) {
            $changes[] = "$field changed from '{$values['old']}' to '{$values['new']}'";
        }
        return implode(', ', $changes);
    }

    public function isCreate(): bool
    {
        return $this->action === 'create';
    }

    public function isUpdate(): bool
    {
        return $this->action === 'update';
    }

    public function isDelete(): bool
    {
        return $this->action === 'delete';
    }
}