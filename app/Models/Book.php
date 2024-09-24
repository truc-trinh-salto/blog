<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'book_id';


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'book_id','book_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }

    public function branches():BelongsToMany{
        return $this->belongsToMany(
                        Branch::class,
                        'branchstockitem',
                        'book_id',
                        'branch_id')
                    ->withPivot('status', 'branch_select')
                    ->wherePivot('status',1);
    }
    
}
