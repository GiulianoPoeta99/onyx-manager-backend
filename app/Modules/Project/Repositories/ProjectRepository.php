<?php namespace Modules\Project\Repositories;

use CodeIgniter\Validation\Validation;

use Core\Repositories\BaseRepository;
use Modules\Project\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct(Project $model, Validation $validator)
    {
        parent::__construct($model, $validator);
    }

    public function findAllByUserID(int $userId): array
    {
        return $this->findWhere(['user_id' => $userId]);
    }
}