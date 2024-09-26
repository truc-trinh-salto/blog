
<style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/home">Book Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('message._CATEGORY') }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($categories as $category)
                                <a class="dropdown-item" href="category?category_id={{ $category['category_id'] }}&name={{$category['name_category']}}">{{ $category['name_category'] }}</a>
                            @endforeach    
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(session()->has('user_id'))
                                    {{ session('fullname')}}
                                @else
                                    {{ __('message._USERNAME') }}
                                @endif
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(session()->has('user_id'))
                                <a class="dropdown-item" href="/history">{{ __('message._HISTORY') }}</a>
                                <a class="dropdown-item" href="/profile">{{ __('message._PROFILE') }}</a>
                                <a class="dropdown-item" href="/codesale">{{ __('message._CODESALE') }}</a>
                                <a class="dropdown-item" href="/store_system">{{ __('message._SYSTEM') }}</a>
                            @else
                                <a class="dropdown-item" href="/login">{{ __('message._LOGIN') }}</a>
                            @endif
                                <a class="dropdown-item" href="/logout">{{ __('message._LOGOUT') }}</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown" id="show_cart">
                        <a class="nav-link dropdown-toggle display-count-cart" href="/cart/showCart" id="navbarDropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge">{{ count(session('cart')) }}</span> Cart <span class="glyphicon glyphicon-shopping-cart"></span> 
                        </a>
                        @if(count(session('cart')) >0)
                        <div class="dropdown-menu display-cart"aria-labelledby="navbarDropdown">
                            @foreach($book_cart as $cart)
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <img width="70" height="70" src="{{ $cart['address'] }}">
                                    </div>
                                    <div class="col-6">
                                        <a href="">{{ $cart['title'] }}</a>

                                        <!-- Blade template using raw php -->
                                        @php 
                                            $index = array_search($cart['book_id'], session('cart'));
                                            $price = $cart['price'];
                                            if($cart['sale'] != null && $cart['sale'] > 0) {
                                                $price = $price - ($price * $cart['sale'] / 100);
                                            }
                                        @endphp
                                        <!-- Blade template using raw php -->

                                        <p>{{ session('qty_array')[$index] }}</p>
                                        <p class="font-weight-bold text-info" style="font-size:10px;">{{ number_format($price * session('qty_array')[$index],2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </li>
                    <li class="nav-item nav-link">
					<script>
						function changeLang(){
						document.getElementById('form_lang').submit();
						}
					</script>
						<form method='get' action='' id='form_lang'>
                            <input type='hidden' name='order_id' value=>
                            <input type='hidden' name='book_id' value=>
                            <input type='hidden' name='username' value=>
							{{ __('message._SELECTLANGUAGES')}} <select name='lang' class="text-info font-weight-bold" onchange='changeLang();' >
							<option value='en' @selected(session()->has('lang') && session('lang') == 'en')>
                                English
                            </option>

							<option value='vi' @selected(session()->has('lang') && session('lang') == 'vi')>
                                Vietnamese
                            </option>
							</select>
						</form>
					</li>
                </ul>
            </div>
        </div>
    </nav>