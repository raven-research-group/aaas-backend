<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class Organization extends Authenticatable
{
    use HasFactory, HasUuids, HasApiTokens;

    protected $fillable = ['id', 'name', 'primary_contact', 'secondary_contact', 'api_secret', 'whitelisted_ips'];

    protected $hidden = ['created_at', 'updated_at'];

    protected static function booted()
    {
        static::creating(function ($organization) {
            do {
                $apiSecret = Str::random(32);
            } while (Organization::where('api_secret', $apiSecret)->exists());

            $organization->api_secret = $apiSecret;
        });
    }



    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
