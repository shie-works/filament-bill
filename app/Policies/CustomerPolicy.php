<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy extends BasePolicy
{
    protected $modelName = 'customer';
}
