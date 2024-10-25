@props([
    'title'
])

<!-- Blade template componet using model in constructor  -->
<div class="card-body">
    <a href="detail_product?book_id={{ $book['book_id'] }}">

        <!-- Blade template scope of slot  -->
        <h5 class="card-title" {{$title->attributes}}>{{ $title }}</h5>
    </a>
    <p class="card-text" >{{ __('message._AUTHORS') }}: {{ $book->authors }}</p>

        <!-- Blade using if statements -->
        @if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null)
            <p class="text-success font-weight-bold">
                <del class="text-danger">{{ number_format($book['price'],2) }}</del> 
                {{ number_format($book['price'] - $book['sale']*$book['price'] / 100,2) }}
            </p>
        @else
            <p class="font-weight-bold">{{ number_format($book['price'],2) }}</p>
        @endif

    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    
    @if($book['sale'] != 0 && $book['sale'] != null)
        <input type="hidden" name="price" value="{{ $book['price'] - $book['sale']*$book['price'] / 100 }}">
    @else
        <input type="hidden" name="price" value="{{ $book['price'] }}">
    @endif
                                    
                        <!-- Blade template Additional statement -->
    <button type="submit" @disabled($book['stock'] <= 0) class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="{{ $book['book_id'] }}" name="add-to-cart" >
    {{ __('message._ADDTOCART') }}
    </button>
</div>