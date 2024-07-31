<?php

namespace Modules\UserRole\Controllers;

use Libraries\BaseController;
use Modules\UserRole\Entities\UserRole;

class UserRoleController extends BaseController
{
    protected $modelName = 'Modules\UserRole\Models\UserRoleModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('UserRole no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new UserRole($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'UserRole creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('UserRole no encontrado');
        }

        $entity = new UserRole($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'UserRole actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('UserRole no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'UserRole eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el user_role');
    }
}
