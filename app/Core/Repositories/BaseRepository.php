<?php

namespace App\Repositories;

use CodeIgniter\Model;
use CodeIgniter\Validation\Validation;
use CodeIgniter\Database\BaseBuilder;

class BaseRepository
{
    protected Model $model;
    protected Validation $validator;

    public function __construct(Model $model, Validation $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    // Operaciones CRUD básicas
    public function findAll(int $limit = 0, int $offset = 0)
    {
        return $this->model->findAll($limit, $offset);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->insert($data);
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    // Validación
    public function validate(array $data, array $rules = null): bool
    {
        $rules = $rules ?? $this->model->getValidationRules();
        return $this->validator->setRules($rules)->run($data);
    }

    public function getValidationErrors(): array
    {
        return $this->validator->getErrors();
    }

    // Búsqueda avanzada
    public function findWhere(array $conditions, int $limit = 0, int $offset = 0)
    {
        return $this->model->where($conditions)->findAll($limit, $offset);
    }

    public function findOneWhere(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }

    // Conteo
    public function count(array $conditions = []): int
    {
        return $this->model->where($conditions)->countAllResults();
    }

    // Paginación
    public function paginate(int $perPage = 20, int $page = 1, array $conditions = [])
    {
        return $this->model->where($conditions)->paginate($perPage, 'default', $page);
    }

    // Operaciones en lote
    public function createBatch(array $data)
    {
        return $this->model->insertBatch($data);
    }

    public function updateBatch(array $data, string $key)
    {
        return $this->model->updateBatch($data, $key);
    }

    // Transacciones
    public function beginTransaction()
    {
        $this->model->db->transBegin();
    }

    public function commitTransaction()
    {
        $this->model->db->transCommit();
    }

    public function rollbackTransaction()
    {
        $this->model->db->transRollback();
    }

    // Query Builder
    public function getBuilder(): BaseBuilder
    {
        return $this->model->builder();
    }

    // Soft Deletes
    public function withDeleted()
    {
        return $this->model->withDeleted();
    }

    public function onlyDeleted()
    {
        return $this->model->onlyDeleted();
    }

    // Relaciones
    public function with(string ...$relations)
    {
        return $this->model->with(...$relations);
    }

    // Ordenamiento
    public function orderBy(string $column, string $direction = 'ASC')
    {
        return $this->model->orderBy($column, $direction);
    }

    // Búsqueda por texto
    public function search(string $term, array $columns)
    {
        $builder = $this->model->builder();
        foreach ($columns as $column) {
            $builder->orLike($column, $term);
        }
        return $builder->get()->getResult();
    }

    // Recuperar solo ciertas columnas
    public function select(array $columns)
    {
        return $this->model->select(implode(', ', $columns));
    }
}