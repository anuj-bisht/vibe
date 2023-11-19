@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">

                {{-- <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div> --}}












                <div class="card-body" style="text-align: center; margin-bottom:15px; margin-top:0px;">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="login-head">
                            <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
                        </div>
                        <div class="row mb-12" style="margin-bottom: 0px !important;">
                            <h4 style="font-weight: 900; padding-bottom:1rem;" class="col-md-6 col-form-label text-md-end">{{ __('Forgot Password') }}</h4>
                        </div>

                        <div class="row mb-12" style="display: flex; flex-direction: column;">
                            <div class="col-md-6">
                                <label for="email" style="font-size:0.857rem;" class=" col-form-label text-md-end">{{ __('Registered Email ID') }}</label>
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
                        <div class="row mb-0" style="margin-top:3rem; justify-content:center;">
                            <div class="col-md-8">


                                <button type="submit" class="btn btn-primary" style="background-color: #32AD89 !important; border:#32AD89 !important; color:white; width:inherit;">
                                    {{ __('Send') }}
                                </button>


                            </div>
                        </div>
                        {{-- <div class="row mb-0" style="margin-top:3rem; justify-content:center;">
                            <div class="col-md-8">


                                <a type="submit"  style="background-color:  color: black; width:inherit;">
                                    {{ __('Back to login page') }}
                                </a>


                            </div>
                        </div> --}}
                    </form>
                    <p class="text-center mt-2">
                        <a href="{{route('login')}}"> <i data-feather="chevron-left"></i> Back to login </a>
                    </p>
                </div>












            </div>
        </div>
    </div>
</div>
@endsection
