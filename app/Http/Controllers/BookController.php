<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPostRequest;
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

        //Request retrieveing cookie
        $cookie = $request->cookie('name');

        //Define cookies
        $cookie = cookie('name', 'value', 5);
    
        //Response attaching cookies
        //View passing data to view
        return response()->view('home', ['book' => $book])->cookie($cookie);
    }

    public function create(BookPostRequest $request){
        $validator = $request->validated();

        var_dump(session());

        return redirect('/mangement/book/create');
    }
}
