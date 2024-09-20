<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;


class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $primaryKey = 'comment_id';

    public function book()
    {
        return $this->belongsTo(Book::class,'book_id','book_id');
    }
}
