{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"></head>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="{{asset("css/login.css")}}">
    <title>Login Form</title>
</head>
<body> --}}
    @extends('layouts.app')

@section('content')
    <div class="center">
        <h1>Đăng nhập</h1>
        <form method="POST" action="{{ route('login') }}" >
            @csrf
            <div class="txt_field">
                <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <span></span>
                <label for="email">{{ __('E-Mail Address') }}</label>
                
            </div>

            <div class="txt_field">
                <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <span></span>
                <label for="password">{{ __('Password') }}</label>
                
            </div>
            <div class="pass">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            @error('email')
                        <p class="message_error">{{ $message }}</p>
            @enderror

            @error('password')
                        <p class="message_error">{{ $message }}</p>
            @enderror
            <input type="submit" value="{{ __('Login') }}">
            {{-- <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button> --}}
            <div class="reg_link">
                 {{-- <a href="#">Đăng ký</a> --}}
                 @if (Route::has('password.request'))
                    <a class="" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
{{-- </body>
</html> --}}
@endsection