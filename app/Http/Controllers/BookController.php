<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;

class BookController extends Controller
{
    //
    public function show(Request $request){
        $bookId = $request->id;


        $book = Book::where('book_id',$bookId)->firstOrFail();

        foreach($book->branches as $branch){
            var_dump($branch->pivot->status);
        }


        $cookie = cookie('name', 'value', 5);
        

        return response()->view('home', ['book' => $book])->cookie($cookie);
    }
}
