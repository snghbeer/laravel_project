@extends('layouts.app')
@section('content')

<div class="container mt-5">

    <div class="row d-flex justify-content-center">

        <div class="col-md-7">

            <div class="card p-3 py-4">

                <div class="text-center">
                    @if (!is_null(Auth::user()->avatar))
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" width="100" class="rounded-circle border">
                    @else
                    <img src="{{ Storage::url('avatars/null.jpg') }}" width="100" class="rounded-circle border">
                    @endif

                </div>

                <div class="text-center mt-3">
                    <span class="bg-secondary p-1 px-4 rounded text-white">{{Auth::user()->name}}</span>
                    <h5 class="mt-2 mb-0">{{Auth::user()->email}}</h5>
                    <div class="px-3 mt-1">
                        <p class="fonts">Birthday: {{ \Carbon\Carbon::parse(Auth::user()->bdate)->format('d/m/Y')}}</p>

                    </div>
                    <div class="px-4 mt-1">
                        <p class="fonts">{{Auth::user()->aboutme}}</p>

                    </div>
                       
                    <a class="btn btn-secondary" href="{{route('editProfile', Auth::user()->id)}}">Edit</a>
                    <a class="btn btn-secondary" href="{{route('settingsView', Auth::user()->id)}}">Account settings</a>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection