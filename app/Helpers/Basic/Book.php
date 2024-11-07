<?php
namespace App\Helpers\Basic;
use App\Models\Book as Model;

Class Book{
    public static function getItem($bookId){
        return Model::find($bookId);
    }
}