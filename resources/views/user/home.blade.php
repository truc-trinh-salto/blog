<?php
    session_start();

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


    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['qty_array'] = array();
    }

?>

<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Demo PHP MVC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            }
    </style>
</head>
<body>
    <div class="app">
        <div class="container">
            <script>
                function changeLang(){
                document.getElementById('form_lang').submit();
                }
            </script>
            <div class="mt-4" id="categoryList">
            <?php 
			if(isset($_SESSION['message'])){
				?>
				<div class="alert alert-info text-center">
					<?php echo $_SESSION['message']; ?>
				</div>
				<?php
				unset($_SESSION['message']);
			}
			?>

            <div class="books-show">
            @foreach ($categories as $category)
                <div style="height:50px; width:50px;"></div>
                <h3>{{$category->name_category}}</h3>

                <div class="row mt-4">
                    @foreach($category->books as $book) 
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-course-item">
                                <a href="">

                                    <img class="card-img-top" width="150" height="200" src="<?php echo $book['address']? '../'.$book['address']:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' ?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detail_product?book_id=<?php echo $book['book_id'] ?>">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                    </a>
                                    <p class="card-text" >{{ __('message._AUTHORS') }}: {{ $book->authors }}</p>
                                        <?php if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null): ?>
                                            <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book['price'],2) ?></del> <?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></p>
                                        <?php else:?>
                                            <p class="font-weight-bold"><?php echo number_format($book['price'],2) ?></p>
                                        <?php endif;?>

                                    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    
                                    <?php if($book['sale'] != 0 && $book['sale'] != null): ?>
                                        <input type="hidden" name="price" value="<?php echo $book['price'] - $book['sale']*$book['price'] / 100?>">
                                    <?php else:?>
                                        <input type="hidden" name="price" value="<?php echo $book['price']?>">
                                    <?php endif;?>
                                    

                                    <button type="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>" name="add-to-cart" >
                                    {{ __('message._ADDTOCART') }}
                                    </button>
                                    
                                </div>
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
        </div>
    </div>
    
</body>
</html>
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
                url: '/cart/addtocart',
                method: 'POST',
                data: {book_id: productId, quantity: quantity},
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
<?php

?>
