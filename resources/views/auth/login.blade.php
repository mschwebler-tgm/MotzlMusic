@extends('layouts.app')

@section('content')
    {{--<div class="container">--}}
    {{--<div class="login-options-wrapper">--}}
    {{--<div class="manual-login">--}}
    {{--<h1 class="is-size-1">{{ __('Login') }}</h1>--}}

    {{--<form method="POST" action="{{ route('login') }}">--}}
    {{--@csrf--}}

    {{--<div class="field">--}}
    {{--<label for="email" class="label">{{ __('E-Mail Address') }}</label>--}}

    {{--<div class="control has-icons-left has-icons-right">--}}
    {{--<input id="email" type="email"--}}
    {{--class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email"--}}
    {{--value="{{ old('email') }}" required autofocus>--}}
    {{--<span class="icon is-small is-left">--}}
    {{--<i class="fa fa-envelope"></i>--}}
    {{--</span>--}}
    {{--@if ($errors->has('email'))--}}
    {{--<span class="icon is-small is-right">--}}
    {{--<i class="fas fa-exclamation-triangle"></i>--}}
    {{--</span>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--@if ($errors->has('email'))--}}
    {{--<p class="help is-danger">--}}
    {{--<strong>{{ $errors->first('email') }}</strong>--}}
    {{--</p>--}}
    {{--@endif--}}
    {{--</div> <!-- email -->--}}

    {{--<div class="field">--}}
    {{--<label for="password" class="label">{{ __('Password') }}</label>--}}

    {{--<div class="control">--}}
    {{--<input id="password" type="password"--}}
    {{--class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password"--}}
    {{--required>--}}
    {{--</div>--}}

    {{--@if ($errors->has('password'))--}}
    {{--<p class="help is-danger">--}}
    {{--<strong>{{ $errors->first('password') }}</strong>--}}
    {{--</p>--}}
    {{--@endif--}}
    {{--</div>--}}

    {{--<div class="field">--}}
    {{--<div class="control">--}}
    {{--<label class="checkbox">--}}
    {{--<input type="checkbox" name="remember"--}}
    {{--id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
    {{--{{ __('Remember Me') }}--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="field is-grouped">--}}
    {{--<div class="control">--}}
    {{--<button type="submit" class="button is-link">--}}
    {{--{{ __('Login') }}--}}
    {{--</button>--}}
    {{--<a class="button is-text" href="{{ route('password.request') }}">--}}
    {{--{{ __('Forgot Your Password?') }}--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--<div class="flex-1">--}}
    {{--<div class="flex flex-column align-center h-100">--}}
    {{--<a class="spotify-button" href="/spotify/authorize">--}}
    {{--<svg viewBox="0 0 24 24">--}}
    {{--<path fill="#000000" d="M17.9,10.9C14.7,9 9.35,8.8 6.3,9.75C5.8,9.9 5.3,9.6 5.15,9.15C5,8.65 5.3,8.15 5.75,8C9.3,6.95 15.15,7.15 18.85,9.35C19.3,9.6 19.45,10.2 19.2,10.65C18.95,11 18.35,11.15 17.9,10.9M17.8,13.7C17.55,14.05 17.1,14.2 16.75,13.95C14.05,12.3 9.95,11.8 6.8,12.8C6.4,12.9 5.95,12.7 5.85,12.3C5.75,11.9 5.95,11.45 6.35,11.35C10,10.25 14.5,10.8 17.6,12.7C17.9,12.85 18.05,13.35 17.8,13.7M16.6,16.45C16.4,16.75 16.05,16.85 15.75,16.65C13.4,15.2 10.45,14.9 6.95,15.7C6.6,15.8 6.3,15.55 6.2,15.25C6.1,14.9 6.35,14.6 6.65,14.5C10.45,13.65 13.75,14 16.35,15.6C16.7,15.75 16.75,16.15 16.6,16.45M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />--}}
    {{--</svg>--}}
    {{--Use Spotify to login--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="full" id="root">
        <div class="is-overlay" id="landing-image"></div>
        <a href="https://github.com/mschwebler-tgm" target="_blank">
            <svg style="width:120px; height:120px; color: white;" viewBox="-12 -12 48 48" id="github-link">
                <path fill="#000" cx="24" cy="24"
                      d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z"/>
                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1" fill="transparent"/>
                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1" fill="transparent" id="growing-circle"/>
            </svg>
        </a>
    </div>
@endsection
