@php
    // session_start();

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
    
@endphp

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
        <section layout:fragment="content">
	<div class="col-md-12 grid-margin stretch-card">
    <!-- @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

		<div class="card">
			<div class="card-body">
				<h4 class="card-title">{{ __('message._ADDPRODUCT') }}</h4>
				<form action="/management/book/create" method="POST" class="forms-sample" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s" class="avatar img-circle img-thumbnail" alt="avatar" height="300" width="300">
                        <h6>{{ __('message._UPLOADGALLERY') }}</h6>
                        <input type="file" class="text-center center-block file-upload @error('image') is-invalid @enderror" name="image">
                    </div>

                    @error('image')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

					<div class="form-group">
						<label for="exampleInputName1">{{ __('message._BOOKNAME') }}<span class="text-danger">(*)</span></label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" placeholder="{{ __('message._BOOKNAME') }}" name="name" required value="{{ old('name') }}">
					</div>
                    @error('name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-group">
						<label for="exampleInputAuthor1">{{ __('message._AUTHORS') }}<span class="text-danger">(*)</span></label>
						<input type="text" class="form-control @error('authors') is-invalid @enderror" id="exampleInputAuthor1" placeholder="{{ __('message._AUTHORS') }}" name="authors" required value="{{ old('authors') }}">
					</div>
                    @error('authors')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-group">
						<label for="exampleInputDescription1">{{ __('message._DESCRIPTION') }}</label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="{{ __('message._DESCRIPTION') }}" name="description" value="{{ old('description') }}">
					</div>
                    
					<div class="form-group">
						<label for="exampleInputQuantity">{{ __('message._QUANTITY') }}</label>
						<input type="number" class="form-control @error('quantity') is-invalid @enderror" id="exampleInputQuantity" placeholder="{{ __('message._QUANTITY') }}" name="quantity" min="0" value="{{ old('quantity',0) }}">
					</div>
                    @error('quantity')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

					<div class="form-group">
						<label for="exampleInputHot">{{ __('message._SHOWHOME') }}</label>
						<select class="form-control @error('hotItem') is-invalid @enderror" id="exampleInputHot" name="hotItem">
							<option value="1">{{ __('message._YES') }}</option>
							<option value="0" @selected(old('hotItem') == 0)> {{ __('message._NO') }}</option>
						</select>
					</div>
                    @error('hotItem')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

					<div class="form-group">
						<label for="exampleInputCategory">{{ __('message._CATEGORY') }}<span class="text-danger">(*)</span></label>
						<select class="form-control @error('category') is-invalid @enderror" id="exampleInputCategory" th:field="*{category.id}" name="category" required>
                            @foreach($categories as $category):?>
                                <option value="{{ $category['category_id'] }}" @selected($category['category_id'] == old('category'))>{{$category['name_category']}}</option>
                            @endforeach
						</select>
					</div>
                    @error('category')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

					<div class="form-group">
						<label for="exampleInputPrice">{{ __('message._PRICE') }}<span class="text-danger">(*)</span></label>
						<input type="number" class="form-control @error('price') is-invalid @enderror" id="exampleInputPrice" name="price" required min="1000" value="{{ old('price',1000) }}">
					</div>
                    @error('price')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

					<button type="submit" name="submit" class="btn btn-success mr-2">{{ __('message._SAVE') }}</button>
				</form>
			</div>
		</div>
	</div>

</section>
        </div>
    </div>
    
</body>
</html>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
            
        }
    }


    $(".file-upload").on('change', function(){
        readURL(this);
    });
    });

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

