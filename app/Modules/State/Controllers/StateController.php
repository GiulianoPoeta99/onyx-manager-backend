<?php

namespace Modules\State\Controllers;

use Libraries\BaseController;
use Modules\State\Entities\State;

class StateController extends BaseController
{
    protected $modelName = 'Modules\State\Models\StateModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('State no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new State($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'State creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('State no encontrado');
        }

        $entity = new State($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'State actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('State no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'State eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el state');
    }
}