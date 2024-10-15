<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'authors';

    protected $fillable = [
        'name',
        'address',
    ];

    public function posts()
    {

        return $this->hasMany(Post::class); //satu author bisa banyak post
    }
}
