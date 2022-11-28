@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Account settings') }}</div>
    
                <div class="card-body">

                    <form method="POST" action="{{ route('updateAccount', Auth::user()->id) }}">
                        @csrf

                        <input type="hidden" name=" user_id" id="user_id" value="{{Auth::user()->id}}" />
                        <input type="hidden" name="token" value="{{ csrf_token() }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('email') is-invalid @enderror" name="username" value="{{ Auth::user()->name }}" required autocomplete="username" autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Old Password') }}</label>

                            <div class="col-md-6">
                                <input id="opassw" type="password" class="form-control @error('opassw') is-invalid @enderror" name="opassw" required autocomplete="new-password">

                                @error('opassw')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="npassw" type="password" class="form-control @error('npassw') is-invalid @enderror" name="npassw" required autocomplete="new-password">

                                @error('npassw')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="cpassw" type="password" class="form-control @error('cpassw') is-invalid @enderror" name="cpassw" required autocomplete="new-password">
                                @error('cpassw')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
