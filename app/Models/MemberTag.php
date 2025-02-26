<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTag extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'member_id', 'tag_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
