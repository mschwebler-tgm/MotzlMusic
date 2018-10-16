@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="is-size-1">{{ __('Login') }}</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                <div class="control has-icons-left has-icons-right">
                    <input id="email" type="email"
                           class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email"
                           value="{{ old('email') }}" required autofocus>
                    <span class="icon is-small is-left">
                        <i class="fa fa-envelope"></i>
                    </span>
                    @if ($errors->has('email'))
                    <span class="icon is-small is-right">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    @endif
                </div>
                @if ($errors->has('email'))
                <p class="help is-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </p>
                @endif
            </div> <!-- email -->

            <div class="field">
                <label for="password" class="label">{{ __('Password') }}</label>

                <div class="control">
                    <input id="password" type="password"
                           class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password"
                           required>
                </div>

                @if ($errors->has('password'))
                    <p class="help is-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </p>
                @endif
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button is-link">
                        {{ __('Login') }}
                    </button>
                    <a class="button is-text" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
