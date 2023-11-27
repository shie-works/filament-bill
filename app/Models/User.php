<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserHasPolicy;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasPolicy($modelName, $policyName)
    {

        // dump($modelName);
        // dump($policyName);
        // dump($this->id);
        $userHasPolicy = UserHasPolicy::where('user_id', $this->id)
            ->where('model_name', $modelName)
            ->first();
        // dd($userHasPolicy->get());
        if ($userHasPolicy) {
            // dd($userHasPolicy->$policyName);
            return $userHasPolicy->$policyName;
        }
        return false;
    }

    public function userHasPolicy()
    {
        return $this->hasMany(UserHasPolicy::class);
    }
}
