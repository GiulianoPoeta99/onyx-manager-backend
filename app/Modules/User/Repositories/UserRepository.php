<?php namespace Modules\User\Repositories;

use CodeIgniter\Validation\Validation;

use Core\Repositories\BaseRepository;
use Modules\User\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model, Validation $validator)
    {
        parent::__construct($model, $validator);
    }

    public function findByEmail(string $email): ?UserEntity
    {
        return $this->findOneWhere(['email' => $email]);
    }
}