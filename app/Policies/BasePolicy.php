<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    protected $modelName = '';

    public function viewAny(User $user)
    {
        return $user->hasPolicy($this->modelName, 'view_any');
    }

    public function create(User $user)
    {
        return $user->hasPolicy($this->modelName, 'create');
    }

    public function view(User $user)
    {
        return $user->hasPolicy($this->modelName, 'view');
    }

    public function update(User $user)
    {
        return $user->hasPolicy($this->modelName, 'update');
    }

    public function delete(User $user)
    {
        return $user->hasPolicy($this->modelName, 'delete');
    }

}
