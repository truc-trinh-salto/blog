@extends('layout.app')

@section('content')
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
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="date" name="birthday" value="{{ old('birthday') }}" required>
                    </div>

                    @error('birthday')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="col-md-12">
                        <label for="phone" class="pb-2">{{ __('message._PHONE') }}:</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone" placeholder="{{ __('message._PHONE') }}" name="phone_number" value="{{ old('phone_number') }}" required>
                    </div>

                    @error('phone_number')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-md-12">
                        <label for="username" class="form-label">{{ __('message._USERNAME') }}</label>
                        <input type="username" class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="{{ __('message._USERNAME') }}" value="{{ old('name') }}" required>
                    </div>

                    @error('name')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-md-12">
                        <label for="email" class="form-label">{{ __('message._EMAIL') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('message._EMAIL') }}" value="{{ old('email') }}" required>
                    </div>

                    @error('email') 
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-md-12">
                        <label for="pwd" class="pb-2">{{ __('message._PASSWORD') }}:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="pwd" placeholder="{{ __('message._PASSWORD') }}" name="password" required>
                    </div>

                    @error('password') 
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-md-12">
                        <label for="pwd" class="pb-2">{{ __('message._CONFIRMPASSWORD') }}:</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="pwd" placeholder="{{ __('message._CONFIRMPASSWORD') }}" name="password_confirmation" required>
                    </div>

                    @error('password_confirmation') 
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                    
                    
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input @error('checkTerm') is-invalid @enderror" type="checkbox" value="" id="invalidCheck2" name="checkTerm">
                        <label class="form-check-label" for="invalidCheck2">
                          {{ __('message._AGREETERM') }}
                        </label>
                      </div>
                    </div>

                    @error('checkTerm') 
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-12">
                      <button class="btn btn-success" name="btn" type="submit">{{ __('message._SUBMIT') }}</button>
                    </div>

                    <p class="my-4">{{ __('message._HAVEACCOUNT2') }}? <a style="font-weight:bold" href="/welcome">{{ __('message._LOGIN') }}</a> </p>
                  </form>
            </div>
        </div>
@endsection