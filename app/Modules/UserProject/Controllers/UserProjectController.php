<?php

namespace Modules\UserProject\Controllers;

use Libraries\BaseController;
use Modules\UserProject\Entities\UserProject;

class UserProjectController extends BaseController
{
    protected $modelName = 'Modules\UserProject\Models\UserProjectModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('UserProject no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new UserProject($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'UserProject creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('UserProject no encontrado');
        }

        $entity = new UserProject($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'UserProject actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('UserProject no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'UserProject eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el user_project');
    }
}
