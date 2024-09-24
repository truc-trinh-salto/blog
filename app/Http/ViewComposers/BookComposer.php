<?php
 
namespace App\Http\ViewComposers;
 
use App\Models\Book;
use App\Models\Category;
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
        $categories = Category::all();
        //View Composer
        $view->with('books', $this->books::all())
            ->with('categories', $categories);
    }
}