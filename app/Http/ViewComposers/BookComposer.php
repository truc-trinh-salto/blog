<?php
 
namespace App\Http\ViewComposers;
 
use App\Models\Book;
use Illuminate\View\View;
 
class BookComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected Book $books,
    ) {}
 
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {

        //View Composer
        $view->with('books', $this->books::all());
    }
}