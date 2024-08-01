<?php

namespace Modules\TypeState\Controllers;

use Libraries\BaseController;
use Modules\TypeState\Entities\TypeState;

class TypeStateController extends BaseController
{
    protected $modelName = 'Modules\TypeState\Models\TypeStateModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('TypeState no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new TypeState($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'TypeState creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('TypeState no encontrado');
        }

        $entity = new TypeState($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'TypeState actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('TypeState no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'TypeState eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el type_state');
    }
}