<a class="nav-link dropdown-toggle display-count-cart" href="view_cart.php" id="navbarDropdown" aria-haspopup="true" aria-expanded="false">
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