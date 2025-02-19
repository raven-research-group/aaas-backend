<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory , HasUuids;

    protected $fillable = ['id', 'name', 'organization', 'created_by'];

    protected $hidden = ['created_at', 'updated_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class);
    }
}
