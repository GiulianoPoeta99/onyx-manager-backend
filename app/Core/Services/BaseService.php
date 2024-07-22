<?php namespace Core\Services;

use Core\Repositories\BaseRepository;
use Core\Entities\BaseEntity;

class BaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById($id): ?BaseEntity
    {
        return $this->repository->find($id);
    }

    public function create(array $data): ?BaseEntity
    {
        if (!$this->repository->validate($data)) {
            return null;
        }
        return $this->repository->create($data);
    }

    public function update($id, array $data): ?BaseEntity
    {
        if (!$this->repository->validate($data)) {
            return null;
        }
        return $this->repository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

    public function getErrors(): array
    {
        return $this->repository->getValidationErrors();
    }
}