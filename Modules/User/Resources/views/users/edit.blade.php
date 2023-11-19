@extends('layouts.app')
@section('content')
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update Details</h4>
                        <a href="{{route('user.listing')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

                    </div>
                </div>
            </div>
        </div>
        {{-- @dd($detail->getRoleName()); --}}
        <div class="card-body">
            <form method="POST" action="{{ route('user.update',['id'=>$detail->id]) }}">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" value="{{$detail->name}}" name="name">
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{$detail->email}}" name="email">
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Role</label>
                    <div class="col-md-6">
                       <select class="form-control" name="role_id">
                        <option selected disabled>Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" @if($detail->roles->first()->id == $role->id) selected @endif>{{$role->name}}</option>

                        @endforeach
                       </select>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
</div>
</section>
</div>
@endsection