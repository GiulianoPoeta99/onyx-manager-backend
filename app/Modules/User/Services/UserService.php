<?php namespace Modules\User\Services;

use Core\Services\BaseService;
use Modules\User\Repositories\UserRepository;
use Modules\User\Entities\UserEntity;

class UserService extends BaseService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
        $this->userRepository = $repository;
    }

    public function createUser(array $data): ?UserEntity
    {
        // Asegúrate de que la contraseña se hashea antes de guardarla
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->create($data);
    }

    public function updateUser($id, array $data): ?UserEntity
    {
        // Si se está actualizando la contraseña, hasheala
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->update($id, $data);
    }

    public function authenticateUser(string $email, string $password): ?UserEntity
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }
}