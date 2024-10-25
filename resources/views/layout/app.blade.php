@php
    $type = 'success';
    $message = session('status','');
    if(!session()->has('cart')){
        $cart = array();
        $qtyCart = array();
        session()->put('cart', $cart);
        session()->put('qty_array',$qtyCart);
    }
@endphp

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

            
        <!-- Blade template including subview -->
        @include('user.partials.header')
        <!-- Blade template including subview -->



        <!-- Blade template using component
        Blade template passing data to component -->
        <x-package-alert :$type :$message class="d-flex justify-content-center" name="alert-home"/>
        <!-- Blade template using component -->

        

        <!-- Blade template building layout -->
        <div class="container">
            @yield('content')
        </div>
        <!-- Blade template building layout -->
    </div>
    
</body>
</html>
@yield('javascript')