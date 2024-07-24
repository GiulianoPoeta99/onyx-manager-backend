<?php namespace Modules\Project\Controllers;

use Core\Controllers\BaseController;
use Modules\Project\Services\ProjectService;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Models\Project;

class ProjectController extends BaseController
{
    protected function initService(): void
    {
        $this->service = new ProjectService(new ProjectRepository(new Project(), \Config\Services::validation()));
    }
}