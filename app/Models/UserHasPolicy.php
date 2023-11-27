<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_name',
        'view_any',
        'create',
        'update',
        'delete',
        'view',
    ];

    protected $casts = [
        'view_any' => 'boolean',
        'create' => 'boolean',
        'update' => 'boolean',
        'delete' => 'boolean',
        'view' => 'boolean',
     ];


}
