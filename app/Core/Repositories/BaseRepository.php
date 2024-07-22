<?php namespace Core\Repositories;

use CodeIgniter\Model;
use CodeIgniter\Validation\Validation;
use CodeIgniter\Database\BaseBuilder;

use Core\Entities\BaseEntity;

class BaseRepository
{
    protected Model $model;
    protected Validation $validator;

    public function __construct(Model $model, Validation $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    public function findAll(int $limit = 0, int $offset = 0): array
    {
        return $this->model->findAll($limit, $offset);
    }

    public function find($id): ?BaseEntity
    {
        return $this->model->find($id);
    }

    public function create(array $data): ?BaseEntity
    {
        $id = $this->model->insert($data);
        return $id ? $this->find($id) : null;
    }

    public function update($id, array $data): ?BaseEntity
    {
        $success = $this->model->update($id, $data);
        return $success ? $this->find($id) : null;
    }

    public function delete($id): bool
    {
        return $this->model->delete($id);
    }

    public function validate(array $data, array $rules = null): bool
    {
        $rules = $rules ?? $this->model->getValidationRules();
        return $this->validator->setRules($rules)->run($data);
    }

    public function getValidationErrors(): array
    {
        return $this->validator->getErrors();
    }

    public function findWhere(array $conditions, int $limit = 0, int $offset = 0): array
    {
        return $this->model->where($conditions)->findAll($limit, $offset);
    }

    public function findOneWhere(array $conditions): ?BaseEntity
    {
        return $this->model->where($conditions)->first();
    }

    public function count(array $conditions = []): int
    {
        return $this->model->where($conditions)->countAllResults();
    }

    public function getBuilder(): BaseBuilder
    {
        return $this->model->builder();
    }
}