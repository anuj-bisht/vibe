@extends('layouts.app')




@section('content')
<div class="container" style="position: relative; right: 10%;">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">

                <div class="card-body" style=" margin-bottom:15px; margin-top:0px;">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="login-head" style="text-align: center;">
                            <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
                        </div>
                        <div class="row mb-3" style="margin-bottom: 0px !important;">
                            <h4 style="font-weight: 900; font-size: large; text-align: left !important;" class="col-md-4 col-form-label text-md-end">{{ __('Login') }}</h4>
                        </div>

                        <div class="row mb-12" style="display: flex; flex-direction: column;">
                            <div class="col-md-4">
                                <label for="email" style="font-size:0.857rem;" class=" col-form-label text-md-end">{{ __('Email Id') }}</label>
                            </div>

                            <div class="col-md-12">
                                <input id="email"  type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-12" style="display: flex; flex-direction: column;">
                            <div class="col-md-3">
                                <label for="password"  style="font-size:0.857rem;" class=" col-form-label text-md-end">{{ __('Password') }}</label>
                            </div>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>



                        {{-- <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}




                        <div class="row mb-12" style="flex-wrap:inherit !important;">

                                <div class="col-md-5 form-check" style="margin-left:12px;">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>


                            <div class="col-md-8 ">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size:0.857rem;">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>




                        {{-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-0" style="margin-top:1rem; justify-content:center;">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary" style="background-color: #32AD89 !important; border:#32AD89 !important; color:white; width:inherit;">
                                    {{ __('Sign in') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
