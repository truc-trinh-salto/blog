<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;


class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
