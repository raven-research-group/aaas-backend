<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Passport\ClientRepository;

class Admin extends Authenticatable
{
    use HasFactory, HasUuids , HasApiTokens;

    protected $fillable = ['id','name', 'email', 'password', 'organization_id'];

    protected $hidden = ['password', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($admin) {

            $clientRepository = app(ClientRepository::class);

            $client = $clientRepository->create(
                $admin->id, // User ID for this client
                "{$admin->name} Client", // Client Name
                "", // Redirect URI
                "admins", // Optional provider
                false, // Is Personal Access Client
                true, // Is Password Grant Client
                true // secret
            );


            $admin->client_id = $client->id;
            $admin->client_secret = $client->secret;
            $admin->save();

        });
    }

    protected $casts = [
        'password' => 'hashed',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


}
