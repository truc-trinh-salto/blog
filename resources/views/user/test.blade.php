@php
    // if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    //     $_SESSION['lang'] = $_GET['lang'];
    //     if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
    //         echo "<script type='text/javascript'> location.reload(); </script>";
    //     }
    // }

    // if (isset($_SESSION['lang'])) {
    //     include "public/language/" . $_SESSION['lang'] . ".php";
    // } else {
    //     $_SESSION['lang'] = 'en';
    //     include "public/language/en.php";
    // }

    // $category_last;

    if(!session()->has('cart')){
        $cart = array();
        $qtyCart = array();
        session()->put('cart', $cart);
        session()->put('qty_array',$qtyCart);
    }

@endphp

@extends('layout.app')


@section('content')
    <script>
        function changeLang(){
        document.getElementById('form_lang').submit();
        }
    </script>
    <div class="mt-4" id="categoryList">
        <div class="books-show">
            @foreach ($categories as $category)
                <div style="height:50px; width:50px;"></div>
                    <h3>{{$category->name_category}}</h3>
                    <div class="row mt-4">
                        <!-- Blade using loop -->
                        @foreach($category->books as $book) 
                            <div class="col-sm-6 col-lg-3">
                                <div class="card card-course-item">
                                        <a href="">
                                            <img class="card-img-top" width="150" height="200" src="{{ $book['address']? '../'.$book['address']:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' }}" alt="">
                                        </a>
                                        
                                    <x-card-book :$book>
                                        <x-slot:title text="text-success">
                                            {{ $book['title'] }}
                                        </x-slot>
                                    </x-card-book>
                                </div>
                            </div>
                        @endforeach
                    </div>
            @endforeach
            
            <div class="load-more" lastID="1" style="display: none;">
                    <span>Loading...</span>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">

    if($(window).height() >= $(document).height()){
        const lastID = $('.load-more').attr('lastID');
        $.ajax({
                url: '/book/getInfinity',
                type: 'POST',
                data: {id: lastID},
                beforeSend: function() {
                    $('.load-more').show();
                },
                success: function(html) {
                    $('.load-more').remove();
                    $('#categoryList').append(html);
                    isLoading = false;
                },
                error: function(error) {
                    console.error(error);
                    $('.load-more').hide();
                    isLoading = false;
                }
            });
    }


    document.addEventListener('DOMContentLoaded', function () {


    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-add-to-cart')) {
            event.preventDefault();
            const productId = event.target.dataset.bookId;
            const quantity = 1;

            $.ajax({
                url: '/cart/addToCart',
                method: 'POST',
                data: {book_id: productId, quantity: quantity, _token: '{{ csrf_token() }}'},
                success: function (response) {
                        $('.display-cart').remove();
                        $('.display-count-cart').remove();
                        $('#show_cart').append(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    });

    let isLoading = false;
    $(window).scroll(function() {
        
        if (isLoading) return;
        const lastID = $('.load-more').attr('lastID');
        const distance = $(document).height() - $(window).height();
        if (((distance - $(window).scrollTop()) < 1) && lastID != 0) {
            isLoading = true;
            $.ajax({
                url: '/book/getInfinity',
                type: 'POST',
                data: {id: lastID},
                beforeSend: function() {
                    $('.load-more').show();
                },
                success: function(html) {
                    $('.load-more').remove();
                    $('#categoryList').append(html);
                    isLoading = false;
                },
                error: function(error) {
                    console.error(error);
                    $('.load-more').hide();
                    isLoading = false;
                }
            });
        }
    });
});
</script>
@stop
