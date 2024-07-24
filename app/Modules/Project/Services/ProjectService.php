<?php namespace Modules\Project\Services;

use Core\Services\BaseService;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Entities\ProjectEntity;

class ProjectService extends BaseService
{
    public function __construct(ProjectRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getProjectsByUserId(int $userId): array
    {
        return $this->repository->findAllByUserID($userId);
    }

    public function searchProjects(string $keyword): array
    {
        return $this->repository->findWhere(['name' => $keyword]);
    }
}