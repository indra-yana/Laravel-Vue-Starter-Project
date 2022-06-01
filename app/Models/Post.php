<?php

namespace App\Models;

use App\Src\Traits\Truncateable;
use App\Src\Traits\UUIDPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, UUIDPrimaryKey, Truncateable;

    protected $table = 'posts';
    protected $dates = [
        'created_at', 
        'updated_at'
    ];

    public function getThumbnailAttribute($value)
    {
        return $value ? asset("images/post/$value") : null;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
