<DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Demo PHP MVC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="app">
        <div class="container">
        
        <div class="mt-4">
            <div class="row justify-content-center">
                <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="username">{{ __('message._USERNAME') }}</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                </div>

                <input type="hidden" name="back" value="">
                <div class="form-group">
                    <label for="password">{{ __('message._PASSWORD') }}</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
                <p class="my-4">{{ __('message._HAVEACCOUNT') }}? <a style="font-weight:bold" class="btn btn-success" href="register">{{ __('message._REGISTER') }}</a>
                <p class="my-4">{{ __('message._FORGOTPASSWORD') }}? <a style="font-weight:bold" class="btn btn-info" href="forgotPassword">{{ __('message._FORGOT') }}</a>
                </form>
                </div>
            
            </div>
        </div>
    </div>
  </body>
</html>