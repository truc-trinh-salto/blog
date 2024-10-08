<?php 
    session_start();

    // if(isset($_GET['lang']) && !empty($_GET['lang'])){
    //     $_SESSION['lang'] = $_GET['lang'];
    //     if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
    //      echo "<script type='text/javascript'> location.reload(); </script>";
    //     }
    // }
    // if(isset($_SESSION['lang'])){
    //         include "public/language/".$_SESSION['lang'].".php";
    // }else{
    //         include "public/language/en.php";
    // }
?>

<DOCTYPE html>
<html lang="en">
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
  <style>

</style>
<body>
    <div class="app">
      <div class="d-flex justify-content-center">
        <h1 class="text-info font-weight-bold">Welcome: {{$name}}</h1>
      </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <div class="container">
          <div class="mt-4">
            <div class="row d-flex justify-content-around">
                  <form class="col g-2 justify-content-center form-create" action="" method="post">
                    @csrf
                  <h1 style="text-align: center; font-weight:550;" class ="h3 mb-3 fw-normal">{{ __('message._REGISTER') }}</h1>
                    <div class="col-md-12">
                      <label for="firstname" class="form-label" action="">{{ __('message._NAME') }}</label>
                      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="{{ __('message._NAME') }}" value="{{ old('fullname') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="date" class="pb-2">{{ __('message._BIRTHDAY') }}:</label>
                        <input type="date" class="form-control" id="date" name="birthday" value="{{ old('birthday') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="phone" class="pb-2">{{ __('message._PHONE') }}:</label>
                        <input type="text" class="form-control" id="phone" placeholder="{{ __('message._PHONE') }}" name="phone_number" value="{{ old('phone_number') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="username" class="form-label">{{ __('message._USERNAME') }}</label>
                        <input type="username" class="form-control" id="username" name="name" placeholder="{{ __('message._USERNAME') }}" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label">{{ __('message._EMAIL') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('message._EMAIL') }}" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="pwd" class="pb-2">{{ __('message._PASSWORD') }}:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="{{ __('message._PASSWORD') }}" name="password" required>
                    </div>

                    <div class="col-md-12">
                        <label for="pwd" class="pb-2">{{ __('message._CONFIRMPASSWORD') }}:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="{{ __('message._CONFIRMPASSWORD') }}" name="password_confirmation" required>
                    </div>
                    
                    
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">
                          {{ __('message._AGREETERM') }}
                        </label>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-success" name="btn" type="submit">{{ __('message._SUBMIT') }}</button>
                    </div>

                    <p class="my-4">{{ __('message._HAVEACCOUNT2') }}? <a style="font-weight:bold" href="login">{{ __('message._LOGIN') }}</a> </p>
                  </form>
            </div>
        </div>
      </div>
    </div>
    
</body>
</html>

