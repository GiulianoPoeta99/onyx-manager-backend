<?php

namespace Modules\TypeActivity\Controllers;

use Libraries\BaseController;
use Modules\TypeActivity\Entities\TypeActivity;

class TypeActivityController extends BaseController
{
    protected $modelName = 'Modules\TypeActivity\Models\TypeActivityModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('TypeActivity no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new TypeActivity($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'TypeActivity creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('TypeActivity no encontrado');
        }

        $entity = new TypeActivity($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'TypeActivity actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('TypeActivity no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'TypeActivity eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el type_activity');
    }
}