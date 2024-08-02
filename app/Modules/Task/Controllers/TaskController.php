<?php

namespace Modules\Task\Controllers;

use Libraries\BaseController;
use Modules\Task\Entities\Task;

class TaskController extends BaseController
{
    protected $modelName = 'Modules\Task\Models\TaskModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('Task no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new Task($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'Task creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Task no encontrado');
        }

        $entity = new Task($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'Task actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Task no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'Task eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el task');
    }
}