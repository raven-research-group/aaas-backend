<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

class Admin extends Authenticatable
{
    use HasFactory, HasUuids , HasApiTokens;

    protected $fillable = ['id','name', 'email', 'password', 'organization_id'];

    protected $hidden = ['password', 'created_at', 'updated_at'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


}
