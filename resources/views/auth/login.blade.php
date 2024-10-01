@php
if(!session()->has('cart')){
        $cart = array();
        $qtyCart = array();
        session()->put('cart', $cart);
        session()->put('qty_array',$qtyCart);
    }
@endphp
@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center">
                <h1 class="text-success">District : {{$district}}</h1>
            </div>
            <div class="mt-4">
                <div class="row justify-content-center">
                    <form method="POST" action="/login">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('message._USERNAME') }}</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <input type="hidden" name="back" value="">
                    <div class="form-group">
                        <label for="password">{{ __('message._PASSWORD') }}</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    <p class="my-4">{{ __('message._HAVEACCOUNT') }}? <a style="font-weight:bold" class="btn btn-success" href="/register">{{ __('message._REGISTER') }}</a>
                    <p class="my-4">{{ __('message._FORGOTPASSWORD') }}? <a style="font-weight:bold" class="btn btn-info" href="/forgotPassword">{{ __('message._FORGOT') }}</a>
                    </form>
                </div>

            </div>
@endsection