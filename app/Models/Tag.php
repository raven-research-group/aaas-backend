<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'name', 'organization_id', 'created_by'];

    protected $hidden = ['created_at', 'updated_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }


    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_tags', 'tag_id', 'member_id')
            ->withTimestamps();
    }
}
