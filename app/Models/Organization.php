<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Organization extends Model
{
    use HasFactory; use HasUuids;

    protected $fillable = ['id','name', 'primary_contact', 'secondary_contact'];

    protected $hidden = ['created_at', 'updated_at'];


    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
}
