<?php

namespace Modules\Activity\Controllers;

use Libraries\BaseController;
use Modules\Activity\Entities\Activity;

class ActivityController extends BaseController
{
    protected $modelName = 'Modules\Activity\Models\ActivityModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('Activity no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new Activity($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'Activity creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Activity no encontrado');
        }

        $entity = new Activity($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'Activity actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Activity no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'Activity eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el activity');
    }
}